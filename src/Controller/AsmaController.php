<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;
use Cake\Event\Event;
use Cake\I18n\FrozenTime;
use Cake\Utility\Security;
use Google\Cloud\Language\LanguageClient;
use Firebase\JWT\JWT;
use Cake\Core\Configure;

/**
 * Asma Controller
 *
 * @property \App\Model\Table\AsmaTable $Asma
 *
 * @method \App\Model\Entity\Asma[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class AsmaController extends AppController
{
    public $paginate = [
        'page' => 1,
        'limit' => 10,
        'maxLimit' => 15,
        'fields' => [
            'id', 'fecha', 'calidadSueno', 'dificultadRespirar', 'tos',
            'gravedadTos', 'limitaciones', 'silbidos', 'usoMedicacion', 'espirometria',
            'factoresCrisis', 'estadoGeneral'
        ],
        'sortWhitelist' => [
            'id', 'fecha', 'calidadSueno', 'dificultadRespirar', 'tos',
            'gravedadTos', 'limitaciones', 'silbidos', 'usoMedicacion', 'espirometria',
            'factoresCrisis', 'estadoGeneral'
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

    /*
    Función que controla el token del header de autroización y controla el acceso a las funciones restringidas del controlador
    */
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

        if(($action == "analisisDeSentimientos" || $action == "todosAsmaFichas" || $action == "delete") && $rol == "administrador"){
            return true;    
        }else if(($action == "analisisDeSentimientos" || $action == "todosAsmaFichas") && $rol == "medico"){
            return true;
        }else if(($action == "getCubierto" || $action == "add") && $rol == "paciente"){
            return true;
        }else{
            return false;
        }
    }
    
    /*
    Devuelve la información de los informes de asma de una ficha
    */
    public function asmaFichas()
    {
        $this->autoRender = false;
        $data = $this->request->getData();
        $this->paginate['page'] = $data['page']+1;
        $this->paginate['limit'] = $data['limit'];

        $conditions = array('ficha' => $data['id']);

        $asma = $this->Asma->find('all', array('conditions' => $conditions));
        $paginador = $this->paginate($asma);

        foreach($paginador as $asma){

            $fecha = FrozenTime::parse($asma['fecha']);
            $asma->fecha = $fecha;
            
            $asma->fecha =  $asma->fecha->i18nFormat('dd/MM/YYYY HH:mm');

            $asma = $this->desencriptarInforme($asma);

        }
       
        $this->response->statusCode(200);
        $this->response->type('json');
        $json = json_encode($paginador);
        $this->response->body($json);
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
                'keyFilePath' => Configure::read('keyFilePath')
            ]);

            $asma = $this->Asma->get($id);
            $asma = $this->desencriptarInforme($asma);

            $text = $asma->estadoGeneral;

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
    Devuelve la información de todas los informes de asma de una ficha
    Solo accesible por el administrador y el médico
    */
    public function todosAsmaFichas()
    {
        $check = $this->checkToken();
        if($check){
            $this->autoRender = false;
            $data = $this->request->getData();
            $asma = $this->Asma->find()->where(['ficha' => $data['id']])->all();

            foreach($asma as $asmaFicha){

                $fecha = FrozenTime::parse($asmaFicha['fecha']);
                $asmaFicha->fecha = $fecha;
                
                $asmaFicha->fecha =  $asmaFicha->fecha->i18nFormat('dd/MM/YYYY HH:mm');

                $asmaFicha = $this->desencriptarInforme($asmaFicha);

            }
        
            $this->response->statusCode(200);
            $this->response->type('json');
            $json = json_encode($asma);
            $this->response->body($json);
        }else{
            $this->response->statusCode(403);
            $this->response->type('json');
            $json = json_encode("error");
            $this->response->body($json);
        }
    }

    /*
    Número de informes de asma de una ficha
    */
    public function numeroInformesAsma()
    {
        $this->autoRender = false;
        $data = $this->request->getData();
        $conditions = array('ficha' => $data['id']);
        $asma = $this->Asma->find('all', array('conditions' => $conditions));

        $i = 0;

        foreach($asma as $asma){
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
    Información de un informe de asma
    */
    public function view($id = null)
    {
        $this->autoRender = false;
        $asma = $this->Asma->get($id);

        $fecha = FrozenTime::parse($asma['fecha']);
        $asma->fecha = $fecha;
        
        $asma->fecha = $asma->fecha->i18nFormat('dd/MM/YYYY HH:mm');

        $asma = $this->desencriptarInforme($asma);
       
        $this->response->statusCode(200);
        $this->response->type('json');
        $json = json_encode($asma);
        $this->response->body($json);
    }


     /*
    Elimina un informe de asma
    Solo accesible por el administrador
    */
    public function delete($id = null)
    {
        $check = $this->checkToken();
        if($check){
            $this->autoRender = false;
            $informe = $this->Asma->get($id);
            $this->Asma->delete($informe);

            $this->response->statusCode(200);
            $this->response->type('json');
            $json = json_encode($id);
            $this->response->body($json);
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

            $informes = $this->Asma->find()->where(['fecha LIKE' => '%'.$fecha.'%'])->where(['ficha' => $id])->all();
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
    Comprueba si se ha cubierto el informe en el dia actual
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
            $asma = $this->Asma->newEntity();
            $asma = $this->Asma->patchEntity($asma, $data);
            if($this->Asma->save($asma)){
                $this->response->statusCode(200);
                $this->response->type('json');
                $json = json_encode($data);
                $this->response->body($json);
            }else{
                $this->response->statusCode(200);
                $this->response->type('json');
                $json = json_encode($data);
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
    Desencripta la informacion de un momento
    */
    public function desencriptarInforme($asma){
        $asma['calidadSueno'] = Security::decrypt(base64_decode($asma['calidadSueno']), Security::salt());
        $asma['dificultadRespirar'] = Security::decrypt(base64_decode($asma['dificultadRespirar']), Security::salt());
        $asma['tos'] = Security::decrypt(base64_decode($asma['tos']), Security::salt());
        $asma['gravedadTos'] = Security::decrypt(base64_decode($asma['gravedadTos']), Security::salt());
        $asma['limitaciones'] = Security::decrypt(base64_decode($asma['limitaciones']), Security::salt());
        $asma['silbidos'] = Security::decrypt(base64_decode($asma['silbidos']), Security::salt());
        $asma['usoMedicacion'] = Security::decrypt(base64_decode($asma['usoMedicacion']), Security::salt());
        $asma['espirometria'] = Security::decrypt(base64_decode($asma['espirometria']), Security::salt());
        $asma['factoresCrisis'] = Security::decrypt(base64_decode($asma['factoresCrisis']), Security::salt());
        $asma['estadoGeneral'] = Security::decrypt(base64_decode($asma['estadoGeneral']), Security::salt());
        return $asma;
    }
}
