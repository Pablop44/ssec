<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;
use Cake\I18n\FrozenTime;
use Cake\Event\Event;
use Cake\I18n\Time;
use Cake\Utility\Security;
use Firebase\JWT\JWT;

/**
 * Nota Controller
 *
 * @property \App\Model\Table\NotaTable $Nota
 *
 * @method \App\Model\Entity\Notum[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class NotaController extends AppController
{
    public $paginate = [
        'page' => 1,
        'limit' => 10,
        'maxLimit' => 15,
        'fields' => [
            'id', 'fecha', 'datos', 'ficha'
        ],
        'sortWhitelist' => [
            'id', 'fecha', 'datos', 'ficha'
        ]
    ];
    
    public function initialize()
    {
        parent::initialize();
        $this->loadComponent('Csrf');
        $this->loadComponent('Paginator');
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

        if(($action == "add" || $action == "editarNota" || $action == "delete") && $rol == "administrador"){
            return true;    
        }else if(($action == "add" || $action == "editarNota") && $rol == "medico"){
            return true;
        }else{
            return false;
        }
    }


    public function notasFicha()
    {
        $this->autoRender = false;
        $data = $this->request->getData();

        $this->paginate['page'] = $data['page']+1;
        $this->paginate['limit'] = $data['limit'];

        if(isset($data['tipo'])){
            $this->paginate['order'] = [$data['tipo'] => 'desc'];
        }

        if(!isset($data['filtro'])){
            $conditions = array('ficha' => $data['idFicha']);
        }else{
            if(isset($data['filtro']['fechaInicio'])){
                $fechaInicio =  array('fecha >' => $data['filtro']['fechaInicio']);
            }else{
                $fechaInicio = "";
            }
            if(isset($data['filtro']['fechaFin'])){
                $fechaFin =  array('fecha <' => $data['filtro']['fechaFin']);
            }else{
                $fechaFin = "";
            }
            if(isset($data['filtro']['texto'])){
                $texto = array('datos LIKE' => '%'.$data['filtro']['texto'].'%');
            }else{
                $texto = "";
            }
            $conditions = array('ficha' => $data['idFicha'], $fechaInicio, $fechaFin, $texto);
        }

        $nota = $this->Nota->find('all', array('conditions' => $conditions));
        $paginador = $this->paginate($nota);

        foreach($paginador as $nota){
            $fecha = FrozenTime::parse($nota['fecha']);
            $nota->fecha = $fecha;
            
            $nota->fecha =  $nota->fecha->i18nFormat('dd/MM/YYYY HH:mm:ss');
            $nota = $this->desencriptarNota($nota);
        }

        $this->response->statusCode(200);
        $this->response->type('json');
        $json = json_encode($paginador);
        $this->response->body($json);
    }


    public function numeroNotas()
    {
        $this->autoRender = false;
        $data = $this->request->getData();

        if(!isset($data['filtro'])){
            $conditions = array('ficha' => $data['idFicha']);
        }else{
            if(isset($data['filtro']['fechaInicio'])){
                $fechaInicio =  array('fecha >' => $data['filtro']['fechaInicio']);
            }else{
                $fechaInicio = "";
            }
            if(isset($data['filtro']['fechaFin'])){
                $fechaFin =  array('fecha <' => $data['filtro']['fechaFin']);
            }else{
                $fechaFin = "";
            }
            if(isset($data['filtro']['texto'])){
                $texto = array('datos LIKE' => '%'.$data['filtro']['texto'].'%');
            }else{
                $texto = "";
            }
            $conditions = array('ficha' => $data['idFicha'], $fechaInicio, $fechaFin, $texto);
        }

        $nota = $this->Nota->find('all', array('conditions' => $conditions));
        $i = 0;
        foreach($nota as $nota){
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
    función que crea una nueva nota
    */
    public function add()
    {
        $check = $this->checkToken();
        if($check){
            $this->autoRender = false;
            $notum = $this->Nota->newEntity();
            $notum = $this->Nota->patchEntity($notum, $this->request->getData());
            $this->Nota->save($notum);
            $this->response->statusCode(200);
            $this->response->type('json');
            $json = json_encode($notum);
            $this->response->body($json);
        }else{
            $this->response->statusCode(403);
            $this->response->type('json');
            $json = json_encode("error");
            $this->response->body($json);
        }
    }

    /*
    Función que edita la información de una nota
    */
    public function editarNota()
    {
        $check = $this->checkToken();
        if($check){
            $this->autoRender = false;
            $data = $this->request->getData();
            
            $nota = $this->Nota->get($data['id']);
            $nota = $this->desencriptarNota($nota);

            $x = array();
            $x['datos'] = $data['datos'];
        
            $nota2 = $this->Nota->patchEntity($nota, $x);
            $this->Nota->save($nota2);
            $this->response->statusCode(200);
            $this->response->type('json');
            $json = json_encode($nota2);
            $this->response->body($json);
        }else{
            $this->response->statusCode(403);
            $this->response->type('json');
            $json = json_encode("error");
            $this->response->body($json);
        }
    }

    /*
    Función que elimina una nota
    */
    public function delete($id = null)
    {
        $check = $this->checkToken();
        if($check){
            $this->autoRender = false;
            $notum = $this->Nota->get($id);
            if($this->Nota->delete($notum)){
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
    Función que desencipta la información de una nota
    */
    public function desencriptarNota($nota){
        $nota['datos'] = Security::decrypt(base64_decode($nota['datos']), Security::salt());
        return $nota;
    }
}
