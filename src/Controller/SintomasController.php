<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;
use Cake\Event\Event;
use Cake\I18n\FrozenTime;

/**
 * Sintomas Controller
 *
 * @property \App\Model\Table\SintomasTable $Sintomas
 *
 * @method \App\Model\Entity\Sintoma[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class SintomasController extends AppController
{

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

        if(($action == "add") && $rol == "paciente"){
            return true;    
        }else{
            return false;
        }
    }

    /*
    Añade sintomas al informe de migrañas
    */
    public function add()
    {
        $check = $this->checkToken();
        if($check){
            $this->autoRender = false;
            $data = $this->request->getData();
            $sintoma = $this->Sintomas->newEntity();
            $sintoma = $this->Sintomas->patchEntity($sintoma, $data);
            if($this->Sintomas->save($sintoma)){
                $this->response->statusCode(200);
                $this->response->type('json');
                $json = json_encode($sintoma);
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
}
