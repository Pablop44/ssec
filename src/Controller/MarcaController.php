<?php
namespace App\Controller;

use Cake\Event\Event;
use App\Controller\AppController;
use Cake\Utility\Security;
use Firebase\JWT\JWT;
use Cake\ORM\TableRegistry;

/**
 * Marca Controller
 *
 * @property \App\Model\Table\MarcaTable $Marca
 *
 * @method \App\Model\Entity\Marca[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class MarcaController extends AppController
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

        if(($action == "todasMarcas" || $action == "add") && $rol == "administrador"){
            return true;    
        }else if(($action == "todasMarcas") && $rol == "medico"){
            return true;
        }else{
            return false;
        }
    }

     /*
    Devuelve todas las marcas del sistema
    */
    public function todasMarcas()
    {
        $check = $this->checkToken();
        if($check){
            $this->autoRender = false;
            $marca = $this->Marca->find()->all();

            $this->response->statusCode(200);
            $this->response->type('json');
            $json = json_encode($marca);
            $this->response->body($json);
        }else{
            $this->response->statusCode(403);
            $this->response->type('json');
            $json = json_encode("error");
            $this->response->body($json);
        }
    }

    /*
    Añade una marca al sistema
    */
    public function add()
    {
        $check = $this->checkToken();
        if($check){
            $this->autoRender = false;
            $marca = $this->Marca->newEntity();
            $marca = $this->Marca->patchEntity($marca, $this->request->getData());
            $this->Marca->save($marca);

            $this->response->statusCode(200);
            $this->response->type('json');
            $json = json_encode($marca);
            $this->response->body($json);
        }else{
            $this->response->statusCode(403);
            $this->response->type('json');
            $json = json_encode("error");
            $this->response->body($json);
        }
    }
}
