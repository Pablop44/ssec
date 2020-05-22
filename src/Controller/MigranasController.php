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
 * Migranas Controller
 *
 * @property \App\Model\Table\MigranasTable $Migranas
 *
 * @method \App\Model\Entity\Migrana[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class MigranasController extends AppController
{

    public $paginate = [
        'page' => 1,
        'limit' => 10,
        'maxLimit' => 15,
        'fields' => [
            'id', 'fecha', 'frecuencia', 'duracion', 'horario',
            'finalizacion', 'tipoEpisodio', 'intensidad', 'limitaciones', 'despiertoNoche',
            'estadoGeneral'
        ],
        'sortWhitelist' => [
            'id', 'fecha', 'frecuencia', 'duracion', 'horario',
            'finalizacion', 'tipoEpisodio', 'intensidad', 'limitaciones', 'despiertoNoche',
            'estadoGeneral'
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

        if(($action == "analisisDeSentimientos" || $action == "delete" || $action == "todosMigranasFichas") && $rol == "administrador"){
            return true;    
        }else if(($action == "analisisDeSentimientos" || $action == "todosMigranasFichas") && $rol == "medico"){
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
                'keyFilePath' => Configure::read('keyFilePath')
            ]);

            $migranas = $this->Migranas->get($id);
            $migranas = $this->desencriptarInforme($migranas);

            $text = $migranas->estadoGeneral;

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
    Devuelve la información de los informes de migrañas de una ficha
    */
    public function migranasFichas()
    {
        $this->autoRender = false;
        $data = $this->request->getData();
        $this->paginate['page'] = $data['page']+1;
        $this->paginate['limit'] = $data['limit'];

        $conditions = array('ficha' => $data['id']);

        $migranas = $this->Migranas->find('all', array('conditions' => $conditions));
        $paginador = $this->paginate($migranas);

        foreach($paginador as $migranas){

            $fecha = FrozenTime::parse($migranas['fecha']);
            $migranas->fecha = $fecha;
            
            $migranas->fecha =  $migranas->fecha->i18nFormat('dd/MM/YYYY HH:mm');
            
            $sintomas = TableRegistry::getTableLocator()->get('Sintomas');
            $sintomasIterador = $sintomas->find()->where(['migranas' => $migranas['id']])->all();

            foreach($sintomasIterador as $sintomas){
                unset($sintomas['migranas']);
                $sintomas = $this->desencriptarSintomas($sintomas);
            }

            $migranas['sintomas'] = $sintomasIterador;

            $factores = TableRegistry::getTableLocator()->get('Factores');
            $factoresIterador = $factores->find()->where(['migranas' => $migranas['id']])->all();

            foreach($factoresIterador as $factores){
                unset($factores['migranas']);
                $factores = $this->desencriptarFactores($factores);
            }

            $migranas['factores'] = $factoresIterador;
            $migranas = $this->desencriptarInforme($migranas);
            
        }
        $this->response->statusCode(200);
        $this->response->type('json');
        $json = json_encode($paginador);
        $this->response->body($json);
    }

    /*
    Devuelve la información de todas los informes de migrañas de una ficha
    Solo accesible por el administrador y el médico
    */
    public function todosMigranasFichas()
    {
        $check = $this->checkToken();
        if($check){
            $this->autoRender = false;
            $data = $this->request->getData();
            $migranasInformes = $this->Migranas->find()->where(['ficha' => $data['id']])->all();
            foreach($migranasInformes as $migranas){

                $fecha = FrozenTime::parse($migranas['fecha']);
                $migranas->fecha = $fecha;
                
                $migranas->fecha =  $migranas->fecha->i18nFormat('dd/MM/YYYY HH:mm');
                
                $sintomas = TableRegistry::getTableLocator()->get('Sintomas');
                $sintomasIterador = $sintomas->find()->where(['migranas' => $migranas['id']])->all();

                foreach($sintomasIterador as $sintomas){
                    unset($sintomas['migranas']);
                    $sintomas = $this->desencriptarSintomas($sintomas);
                }

                $migranas['sintomas'] = $sintomasIterador;

                $factores = TableRegistry::getTableLocator()->get('Factores');
                $factoresIterador = $factores->find()->where(['migranas' => $migranas['id']])->all();

                foreach($factoresIterador as $factores){
                    unset($factores['migranas']);
                    $factores = $this->desencriptarFactores($factores);
                }

                $migranas['factores'] = $factoresIterador;
                $migranas = $this->desencriptarInforme($migranas);
            }
            $this->response->statusCode(200);
            $this->response->type('json');
            $json = json_encode($migranasInformes);
            $this->response->body($json);
        }else{
            $this->response->statusCode(200);
            $this->response->type('json');
            $json = json_encode("error");
            $this->response->body($json);
        }
    }

    /*
    Número de informes de migrañas de una ficha
    */
    public function numeroInformesMigranas()
    {
        $this->autoRender = false;
        $data = $this->request->getData();
        $conditions = array('ficha' => $data['id']);
        $migranas = $this->Migranas->find('all', array('conditions' => $conditions));

        $i = 0;
        foreach($migranas as $migranas){
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
    Información de un informe de migranas
    */
    public function view($id = null){

        $this->autoRender = false;
        $migranas = $this->Migranas->get($id);

        $fecha = FrozenTime::parse($migranas['fecha']);
        $migranas->fecha = $fecha;
        
        $migranas->fecha =  $migranas->fecha->i18nFormat('dd/MM/YYYY HH:mm');
        
        $sintomas = TableRegistry::getTableLocator()->get('Sintomas');
        $sintomasIterador = $sintomas->find()->where(['migranas' => $migranas['id']])->all();

        foreach($sintomasIterador as $sintomas){
            unset($sintomas['migranas']);
            $sintomas = $this->desencriptarSintomas($sintomas);
        }

        $migranas['sintomas'] = $sintomasIterador;

        $factores = TableRegistry::getTableLocator()->get('Factores');
        $factoresIterador = $factores->find()->where(['migranas' => $migranas['id']])->all();

        foreach($factoresIterador as $factores){
            unset($factores['migranas']);
            $factores = $this->desencriptarFactores($factores);
        }

        $migranas['factores'] = $factoresIterador;
        $migranas = $this->desencriptarInforme($migranas);
       
        $this->response->statusCode(200);
        $this->response->type('json');
        $json = json_encode($migranas);
        $this->response->body($json);
    }

    /*
    Elimina un informe de migrañas
    Solo accesible por el administrador
    */
    public function delete($id = null)
    {
        $check = $this->checkToken();
        if($check){
            $this->autoRender = false;
            $informe = $this->Migranas->get($id);
            if($this->Migranas->delete($informe)){
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

            $informes = $this->Migranas->find()->where(['fecha LIKE' => '%'.$fecha.'%'])->where(['ficha' => $id])->all();
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
            $migranas = $this->Migranas->newEntity();
            $migranas = $this->Migranas->patchEntity($migranas, $data);
            $result = $this->Migranas->save($migranas);
            if($result){
                $migranas['id'] = $result->id;
                $this->response->statusCode(200);
                $this->response->type('json');
                $json = json_encode($migranas);
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
    public function desencriptarInforme($migranas){
        $migranas['frecuencia'] = Security::decrypt(base64_decode($migranas['frecuencia']), Security::salt());
        $migranas['duracion'] = Security::decrypt(base64_decode($migranas['duracion']), Security::salt());
        $migranas['horario'] = Security::decrypt(base64_decode($migranas['horario']), Security::salt());
        $migranas['finalizacion'] = Security::decrypt(base64_decode($migranas['finalizacion']), Security::salt());
        $migranas['tipoEpisodio'] = Security::decrypt(base64_decode($migranas['tipoEpisodio']), Security::salt());
        $migranas['intensidad'] = Security::decrypt(base64_decode($migranas['intensidad']), Security::salt());
        $migranas['limitaciones'] = Security::decrypt(base64_decode($migranas['limitaciones']), Security::salt());
        $migranas['despiertoNoche'] = Security::decrypt(base64_decode($migranas['despiertoNoche']), Security::salt());
        $migranas['estadoGeneral'] = Security::decrypt(base64_decode($migranas['estadoGeneral']), Security::salt());

        return $migranas;
    }

    /*
    Desencripta la informacion de los sintomas
    */
    public function desencriptarSintomas($sintomas){
        $sintomas['sintomas'] = Security::decrypt(base64_decode($sintomas['sintomas']), Security::salt());
        return $sintomas;
    }

    /*
    Desencripta la informacion de los factores
    */
    public function desencriptarFactores($factores){
        $factores['factores'] = Security::decrypt(base64_decode($factores['factores']), Security::salt());
        return $factores;
    }
}
