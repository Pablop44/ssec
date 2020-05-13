<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;
use Cake\Utility\Security;
use Firebase\JWT\JWT;
use Cake\ORM\TableRegistry;

/**
 * Medicamento Controller
 *
 * @property \App\Model\Table\MedicamentoTable $Medicamento
 *
 * @method \App\Model\Entity\Medicamento[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class MedicamentoController extends AppController
{
    /*
    Variable que contiene los parametros del paginador
    */
    public $paginate = [
        'page' => 1,
        'limit' => 10,
        'maxLimit' => 15,
        'fields' => [
            'nombre', 'viaAdministracion', 'marca', 'dosis'
        ],
        'sortWhitelist' => [
            'nombre', 'viaAdministracion', 'marca', 'dosis'
        ]
    ];

    /*
    Función que inicializa el controlador con las acciones accesibles
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

        if(($action == "medicamentos" || $action == "numeroMedicamentos"  || $action == "delete" || $action == "add" || $action == "buscarMedicamento") && $rol == "administrador"){
            return true;    
        }else if(($action == "medicamentos" || $action == "numeroMedicamentos" || $action == "buscarMedicamento") && $rol == "medico"){
            return true;
        }else{
            return false;
        }
    }

    /*
    Devuelve una lista con los datos de la pagina especificada de todos los medicamentos
    Accesible por el administrador y medico
    */
    public function medicamentos()
    {
        $check = $this->checkToken();
        if($check){
            $this->autoRender = false;
            $data = $this->request->getData();
            $this->paginate['page'] = $data['page']+1;
            $this->paginate['limit'] = $data['limit'];
            if(isset($data['tipo'])){
                $this->paginate['order'] = [$data['tipo'] => 'desc'];
            }
            if(!isset($data['filtro'])){
                $conditions = array();
            }else{
                
                if(isset($data['filtro']['minDosis'])){
                    $minDosis =  array('dosis >' => $data['filtro']['minDosis']);
                }else{
                    $minDosis = "";
                }
                if(isset($data['filtro']['maxDosis'])){
                    $maxDosis =  array('dosis <' => $data['filtro']['maxDosis']);
                }else{
                    $maxDosis = "";
                }
                if(isset($data['filtro']['marca'])){
                    $marca =  array('marca' => $data['filtro']['marca']);
                }else{
                    $marca = "";
                }
                
                if(isset($data['filtro']['nombre'])){
                    $conditions = array('nombre LIKE' => '%'.$data['filtro']['nombre'].'%', $marca, $minDosis, $maxDosis);
                }else{
                    $conditions = array($marca, $minDosis, $maxDosis);
                }  
            }  
            
            $medicamentos = $this->Medicamento->find('all', array('conditions' => $conditions));
            $paginador = $this->paginate($medicamentos);

            $this->response->statusCode(200);
            $this->response->type('json');
            $json = json_encode($paginador);
            $this->response->body($json);
        }else{
            $this->response->statusCode(403);
            $this->response->type('json');
            $json = json_encode("error");
            $this->response->body($json);
        }
    }

    /*
    Devuelve el número de medicamentos presentes en el sistema
    Accesible por el administrador y médico
    */
    public function numeroMedicamentos()
    {
        $check = $this->checkToken();
        if($check){
            $this->autoRender = false;
            $data = $this->request->getData();
            if(!isset($data['filtro'])){
                $conditions = array();
            }else{
                
                if(isset($data['filtro']['minDosis'])){
                    $minDosis =  array('dosis >' => $data['filtro']['minDosis']);
                }else{
                    $minDosis = "";
                }
                if(isset($data['filtro']['maxDosis'])){
                    $maxDosis =  array('dosis <' => $data['filtro']['maxDosis']);
                }else{
                    $maxDosis = "";
                }
                if(isset($data['filtro']['marca'])){
                    $marca =  array('marca' => $data['filtro']['marca']);
                }else{
                    $marca = "";
                }
                
                if(isset($data['filtro']['nombre'])){
                    $conditions = array('nombre' => $data['filtro']['nombre'], $marca, $minDosis, $maxDosis);
                }else{
                    $conditions = array($marca, $minDosis, $maxDosis);
                }  
            }  
            $medicamentos = $this->Medicamento->find('all', array('conditions' => $conditions));
            $i = 0;
            foreach($medicamentos as $medicamento){
                $i++;
            }

            $myobj = array();
            $myobj['numero'] = $i;

            $this->response->statusCode(200);
            $this->response->type('json');
            $json = json_encode($myobj);
            $this->response->body($json);
        }else{
            $this->response->statusCode(403);
            $this->response->type('json');
            $json = json_encode("error");
            $this->response->body($json);
        }
    }

    /*
    Elimina un medicamento del sistema
    Solo accesible por el administrador
    */
    public function delete()
    {
        $check = $this->checkToken();
        if($check){
            $this->autoRender = false;
            $data = $this->request->getData();
            $medicamento = $this->Medicamento->find()->where(['nombre' => $data['nombre']])->all();
            foreach($medicamento as $medicamento){
                $nombre = $medicamento['nombre'];
            }
            $medicamentoAEliminar = $this->Medicamento->get($nombre);
            $this->Medicamento->delete($medicamentoAEliminar);
            $this->response->statusCode(200);
            $this->response->type('json');
            $json = json_encode($medicamentoAEliminar);
            $this->response->body($json);
        }else{
            $this->response->statusCode(403);
            $this->response->type('json');
            $json = json_encode("error");
            $this->response->body($json);
        }
    }

    /*
    buscar un medicamento por su nombre
    accesible por el administrador y por el médico
    */
    public function buscarMedicamento()
    {
        $check = $this->checkToken();
        if($check){
            $this->autoRender = false;
            $data = $this->request->getData();
            $this->paginate['page'] = 0;
            $this->paginate['limit'] = 1;
            $conditions = array('nombre LIKE' => '%'.$data['nombre'].'%');
            $medicamentos = $this->Medicamento->find('all', array('conditions' => $conditions));

            $paginador = $this->paginate($medicamentos);

            $this->response->statusCode(200);
            $this->response->type('json');
            $json = json_encode($paginador);
            $this->response->body($json);
        }else{
            $this->response->statusCode(403);
            $this->response->type('json');
            $json = json_encode("error");
            $this->response->body($json);
        }
    }


    /*
    Añade un nuevo medicamento a sistema
    Solo acesible por el administrador
    */
    public function add()
    {
        $check = $this->checkToken();
        if($check){
            $this->autoRender = false;
            $medicamento = $this->Medicamento->newEntity();
            $medicamento = $this->Medicamento->patchEntity($medicamento, $this->request->getData());
            $this->Medicamento->save($medicamento);

            $this->response->statusCode(200);
            $this->response->type('json');
            $json = json_encode($medicamento);
            $this->response->body($json);
        }else{
            $this->response->statusCode(403);
            $this->response->type('json');
            $json = json_encode("error");
            $this->response->body($json);
        }
    }
}
