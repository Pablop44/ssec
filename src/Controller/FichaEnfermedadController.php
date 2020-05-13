<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;
use Cake\Event\Event;
use Cake\I18n\FrozenTime;
use Cake\Utility\Security;
use Firebase\JWT\JWT;

/**
 * FichaEnfermedad Controller
 *
 * @property \App\Model\Table\FichaEnfermedadTable $FichaEnfermedad
 *
 * @method \App\Model\Entity\FichaEnfermedad[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class FichaEnfermedadController extends AppController
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

        if(($action == "anadirEnfermedad" || $action == "eliminarEnfermedad") && $rol == "administrador"){
            return true;    
        }else if(($action == "anadirEnfermedad" || $action == "eliminarEnfermedad") && $rol == "medico"){
            return true;
        }else{
            return false;
        }
    }

    /*
    permite añadir una enfermedad a la ficha del paciente
     Accesible por el medico y el administrador
    */
    public function anadirEnfermedad()
    {
        $check = $this->checkToken();
        if($check){
            $this->autoRender = false;
            $fichaEnfermedad = $this->FichaEnfermedad->newEntity();
            $fichaEnfermedad = $this->FichaEnfermedad->patchEntity($fichaEnfermedad, $this->request->getData());
            $this->FichaEnfermedad->save($fichaEnfermedad);
            $this->response->statusCode(200);
            $this->response->type('json');
            $json = json_encode($fichaEnfermedad);
            $this->response->body($json);
        }else{
            $this->response->statusCode(403);
            $this->response->type('json');
            $json = json_encode("error");
            $this->response->body($json);
        }
    }

    /*
    elimina una enfermedad de la ficha del paciente
    Accesible por el medico y el administrador
    */
    public function eliminarEnfermedad()
    {
        $check = $this->checkToken();
        if($check){
            $this->autoRender = false;
            $data = $this->request->getData();
            $fichaEnfermedad = $this->FichaEnfermedad->get([$data['ficha'], $data['enfermedad']]);
            if ($this->FichaEnfermedad->delete($fichaEnfermedad)) {
                $this->response->statusCode(200);
                $this->response->type('json');
                $json = json_encode($fichaEnfermedad);
                $this->response->body($json);
            } else {
                $this->response->statusCode(500);
                $this->response->type('json');
                $json = json_encode($fichaEnfermedad);
                $this->response->body($json);
            }
        }else{
            $this->response->statusCode(403);
            $this->response->type('json');
            $json = json_encode("error");
            $this->response->body($json);
        }
    }
}
