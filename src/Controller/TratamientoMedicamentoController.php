<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;
use Cake\Event\Event;
use Cake\I18n\FrozenTime;
use Firebase\JWT\JWT;
use Cake\Utility\Security;

/**
 * TratamientoMedicamento Controller
 *
 * @property \App\Model\Table\TratamientoMedicamentoTable $TratamientoMedicamento
 *
 * @method \App\Model\Entity\TratamientoMedicamento[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class TratamientoMedicamentoController extends AppController
{

     /*
    Función que inicializa el controlador
    */
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

        if(($action == "add") && $rol == "administrador"){
            return true;    
        }else if(($action == "add") && $rol == "medico"){
            return true;
        }else{
            return false;
        }
    }

    /*
    función que asigna un medicamento a un tratamiento
     */
    public function add()
    {
        $check = $this->checkToken();
        if($check){
            $this->autoRender = false;
            $tratamientoMedicamento = $this->TratamientoMedicamento->newEntity();
            $tratamientoMedicamento = $this->TratamientoMedicamento->patchEntity($tratamientoMedicamento, $this->request->getData());
            $this->TratamientoMedicamento->save($tratamientoMedicamento);
            $this->response->statusCode(200);
            $this->response->type('json');
            $json = json_encode($tratamientoMedicamento);
            $this->response->body($json);
        }else{
            $this->response->statusCode(403);
            $this->response->type('json');
            $json = json_encode("error");
            $this->response->body($json);
        }
    }

    /*
    funcion que desasigna un medicamento a un tratamiento
    */
    public function delete()
    {
        $this->autoRender = false;
        $data = $this->request->getData();
        $tratamientoMedicamento = $this->TratamientoMedicamento->get([$data['medicamento'], $data['tratamiento']]);
        if ($this->TratamientoMedicamento->delete($tratamientoMedicamento)){
            $this->response->statusCode(200);
            $this->response->type('json');
            $json = json_encode($tratamientoMedicamento);
            $this->response->body($json);
        } else {
            $this->response->statusCode(500);
            $this->response->type('json');
            $json = json_encode($tratamientoMedicamento);
            $this->response->body($json);
        }
    }
}
