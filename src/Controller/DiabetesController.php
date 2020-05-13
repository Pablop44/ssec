<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;
use Cake\Event\Event;
use Cake\I18n\FrozenTime;
use Cake\Utility\Security;
use Google\Cloud\Language\LanguageClient;
use Firebase\JWT\JWT;

/**
 * Diabetes Controller
 *
 * @property \App\Model\Table\DiabetesTable $Diabetes
 *
 * @method \App\Model\Entity\Diabetes[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class DiabetesController extends AppController
{
    public $paginate = [
        'page' => 1,
        'limit' => 10,
        'maxLimit' => 15,
        'fields' => [
            'id', 'fecha', 'numeroControles', 'nivelBajo', 'frecuenciaBajo',
            'horarioBajo', 'perdidaConocimiento', 'nivelAlto', 'frecuenciaAlto', 'horarioAlto',
            'actividadFisica', 'problemaDieta', 'estadoGeneral'
        ],
        'sortWhitelist' => [
            'id', 'fecha', 'numeroControles', 'nivelBajo', 'frecuenciaBajo',
            'horarioBajo', 'perdidaConocimiento', 'nivelAlto', 'frecuenciaAlto', 'horarioAlto',
            'actividadFisica', 'problemaDieta', 'estadoGeneral'
        ]
    ];

    public function initialize()
    {
        parent::initialize();
        $this->loadComponent('Csrf');
    }

    public function beforeFilter(Event $event) {
        $this->eventManager()->off($this->Csrf);   
    }

    public function checkToken(){
        $this->autoRender = false;
        $token = $this->request->header('Authorization');
        $action = $this->getRequest()->getParam('action');
        $token = str_replace("Bearer ", "",$token);
        $id = JWT::decode(
            $token,
            Security::getSalt(),
            array('HS256')
        );
        $array['id'] = $id;

        $cuenta = TableRegistry::getTableLocator()->get('Cuenta');
        $iteradorCuentas = $cuenta->find()->where(['user' => $array['id']->sub])->all();

        foreach($iteradorCuentas as $iterador){
            $rol = $iterador['rol'];
        }

        if(($action == "analisisDeSentimientos" || $action == "todosDiabetesFichas" || $action == "delete") && $rol == "administrador"){
            return true;    
        }else if(($action == "analisisDeSentimientos" || $action == "todosDiabetesFichas") && $rol == "medico"){
            return true;
        }else if(($action == "getCubierto" || $action == "add") && $rol == "paciente"){
            return true;
        }else{
            return false;
        }
    }

    /*
    Función que realiza una llamada a la API de Análisis de sentimientos de Google y devuelve el resultado
    */
    public function analisisDeSentimientos($id = null)
    {
        $check = $this->checkToken();
        if($check){
            $this->autoRender = false;
            $language = new LanguageClient([
                'projectId' => 'ssec-277009',
                'keyFilePath' => '/Users/pablopazosdominguez/Desktop/google-cloud-sdk/key.json'
            ]);

            $diabetes = $this->Diabetes->get($id);
            $diabetes = $this->desencriptarInforme($diabetes);

            $text = $diabetes->estadoGeneral;

            $annotation = $language->analyzeSentiment($text);
            $sentiment = $annotation->sentiment();

            $array = array();
            $array['sentimiento'] = $sentiment['score'];
        
            $this->response->statusCode(200);
            $this->response->type('json');
            $json = json_encode($array);
            $this->response->body($json);
        }else{
            $this->response->statusCode(403);
            $this->response->type('json');
            $json = json_encode("error");
            $this->response->body($json);
        }
    }

    /*
    Devuelve la información de los informes de diabetes de una ficha
    */
    public function diabetesFichas()
    {
        $this->autoRender = false;
        $data = $this->request->getData();
        $this->paginate['page'] = $data['page']+1;
        $this->paginate['limit'] = $data['limit'];

        $conditions = array('ficha' => $data['id']);

        $diabetes = $this->Diabetes->find('all', array('conditions' => $conditions));
        $paginador = $this->paginate($diabetes);

        foreach($paginador as $diabetes){

            $fecha = FrozenTime::parse($diabetes['fecha']);
            $diabetes->fecha = $fecha;
            
            $diabetes->fecha =  $diabetes->fecha->i18nFormat('dd/MM/YYYY HH:mm');
            
            $momentos = TableRegistry::getTableLocator()->get('Momentos');
            $momentosIterador = $momentos->find()->where(['diabetes' => $diabetes['id']])->all();

            foreach($momentosIterador as $momento){
                unset($momento['diabetes']);
                $momento = $this->desencriptarMomento($momento);
            }
            
            $diabetes['momentos'] = $momentosIterador;

            $diabetes = $this->desencriptarInforme($diabetes);
        }
       
        $this->response->statusCode(200);
        $this->response->type('json');
        $json = json_encode($paginador);
        $this->response->body($json);

    }

    /*
    Devuelve la información de todas los informes de diabetes de una ficha
    Solo accesible por el administrador y el médico
    */
    public function todosDiabetesFichas()
    {

        $check = $this->checkToken();
        if($check){
            $this->autoRender = false;
            $data = $this->request->getData();

            $conditions = array('ficha' => $data['id']);

            $diabetesInformes = $this->Diabetes->find()->where(['ficha' => $data['id']])->all();

            foreach($diabetesInformes as $diabetes){

                $fecha = FrozenTime::parse($diabetes['fecha']);
                $diabetes->fecha = $fecha;
                
                $diabetes->fecha =  $diabetes->fecha->i18nFormat('dd/MM/YYYY HH:mm');
                
                $momentos = TableRegistry::getTableLocator()->get('Momentos');
                $momentosIterador = $momentos->find()->where(['diabetes' => $diabetes['id']])->all();

                foreach($momentosIterador as $momento){
                    unset($momento['diabetes']);
                    $momento = $this->desencriptarMomento($momento);   
                }
                
                $diabetes['momentos'] = $momentosIterador;

                $diabetes = $this->desencriptarInforme($diabetes);
            }
        
            $this->response->statusCode(200);
            $this->response->type('json');
            $json = json_encode($diabetesInformes);
            $this->response->body($json);
        }else{
            $this->response->statusCode(403);
            $this->response->type('json');
            $json = json_encode("error");
            $this->response->body($json);
        }
    }

    /*
    Número de informes de diabetes de una ficha
    */
    public function numeroInformesDiabetes()
    {
        $this->autoRender = false;
        $data = $this->request->getData();

        $conditions = array('ficha' => $data['id']);

        $diabetes = $this->Diabetes->find('all', array('conditions' => $conditions));

        $i = 0;

        foreach($diabetes as $diabetes){
            $i++;
        }

        $myobj = array();
        $myobj['numero'] = $i;
       
        $this->response->statusCode(200);
        $this->response->type('json');
        $json = json_encode($myobj);
        $this->response->body($json);
    }

   
    /*
    Información de un informe de diabetes
    */
    public function view($id = null)
    {
        $this->autoRender = false;
        $diabetes = $this->Diabetes->get($id);

        $fecha = FrozenTime::parse($diabetes['fecha']);
        $diabetes->fecha = $fecha;
        
        $diabetes->fecha =  $diabetes->fecha->i18nFormat('dd/MM/YYYY HH:mm');
        
        $momentos = TableRegistry::getTableLocator()->get('Momentos');
        $momentosIterador = $momentos->find()->where(['diabetes' => $diabetes['id']])->all();

        foreach($momentosIterador as $momento){
            unset($momento['diabetes']);
            $momento = $this->desencriptarMomento($momento);
        }
        
        $diabetes['momentos'] = $momentosIterador;

        $diabetes = $this->desencriptarInforme($diabetes);

        $this->response->statusCode(200);
        $this->response->type('json');
        $json = json_encode($diabetes);
        $this->response->body($json);
    }

    /*
    Elimina un informe de diabetes
    Solo accesible por el administrador
    */
    public function delete($id = null)
    {
        $check = $this->checkToken();
        if($check){
            $this->autoRender = false;
            $informe = $this->Diabetes->get($id);

            if($this->Diabetes->delete($informe)){
                $this->response->statusCode(200);
                $this->response->type('json');
                $json = json_encode($id);
                $this->response->body($json);
            }else{
                $this->response->statusCode(500);
                $this->response->type('json');
                $json = json_encode($id);
                $this->response->body($json);
            }
        }else{
            $this->response->statusCode(403);
            $this->response->type('json');
            $json = json_encode("error");
            $this->response->body($json);
        }
    }

    /*
    Comprueba si se ha cubierto el informe en el dia actual
    Solo accesible por el paciente
    */
    public function getCubierto($id = null)
    {
        $check = $this->checkToken();
        if($check){
            $this->autoRender = false;
            $cubierto['cubierto'] = false;

            $fecha = FrozenTime::now();
            
            $fecha =  $fecha->i18nFormat('YYYY-MM-dd');

            $informes = $this->Diabetes->find()->where(['fecha LIKE' => '%'.$fecha.'%'])->where(['ficha' => $id])->all();
            if(sizeof($informes) > 0){
                $cubierto['cubierto'] = true;
            }
        
            $this->response->statusCode(200);
            $this->response->type('json');
            $json = json_encode($cubierto);
            $this->response->body($json);
        }else{
            $this->response->statusCode(403);
            $this->response->type('json');
            $json = json_encode("error");
            $this->response->body($json); 
        }
    }

    /*
    Añade un nuevo informe a la ficha
    Solo accesible por el paciente
    */
    public function add()
    {
        $check = $this->checkToken();
        if($check){
            $this->autoRender = false;
            $fecha = FrozenTime::now();
            $fecha =  $fecha->i18nFormat('YYYY-MM-dd HH:MM:ss');
            $data = $this->request->getData();
            $data['fecha'] = $fecha;
            $diabetes = $this->Diabetes->newEntity();
            $diabetes = $this->Diabetes->patchEntity($diabetes, $data);
            $result = $this->Diabetes->save($diabetes);
            if($result){
                $diabetes['id'] = $result->id;
                $this->response->statusCode(200);
                $this->response->type('json');
                $json = json_encode($diabetes);
                $this->response->body($json);
            }else{
                header('Access-Control-Allow-Origin: *');
                $this->response->statusCode(500);
                header('Content-Type: application/json');
                $this->set('problema', 'Error al crear la consulta');    
                $this->set('_serialize', ['problema']); 
            } 
        }else{
            $this->response->statusCode(403);
            $this->response->type('json');
            $json = json_encode("error");
            $this->response->body($json); 
        }
    }

    /*
    Desencripta la informacion de un informe
    */
    public function desencriptarInforme($diabetes){
        $diabetes['numeroControles'] = Security::decrypt(base64_decode($diabetes['numeroControles']), Security::salt());
        $diabetes['nivelBajo'] = Security::decrypt(base64_decode($diabetes['nivelBajo']), Security::salt());
        $diabetes['frecuenciaBajo'] = Security::decrypt(base64_decode($diabetes['frecuenciaBajo']), Security::salt());
        $diabetes['horarioBajo'] = Security::decrypt(base64_decode($diabetes['horarioBajo']), Security::salt());
        $diabetes['perdidaConocimiento'] = Security::decrypt(base64_decode($diabetes['perdidaConocimiento']), Security::salt());
        $diabetes['nivelAlto'] = Security::decrypt(base64_decode($diabetes['nivelAlto']), Security::salt());
        $diabetes['frecuenciaAlto'] = Security::decrypt(base64_decode($diabetes['frecuenciaAlto']), Security::salt());
        $diabetes['horarioAlto'] = Security::decrypt(base64_decode($diabetes['horarioAlto']), Security::salt());
        $diabetes['actividadFisica'] = Security::decrypt(base64_decode($diabetes['actividadFisica']), Security::salt());
        $diabetes['problemaDieta'] = Security::decrypt(base64_decode($diabetes['problemaDieta']), Security::salt());
        $diabetes['estadoGeneral'] = Security::decrypt(base64_decode($diabetes['estadoGeneral']), Security::salt());

        return $diabetes;
    }

    /*
    Desencripta la informacion de un momento
    */
    public function desencriptarMomento($momento){
        $momento['momento'] = Security::decrypt(base64_decode($momento['momento']), Security::salt());
        return $momento;
    }
}
