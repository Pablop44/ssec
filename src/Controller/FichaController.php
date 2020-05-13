<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;
use Cake\Event\Event;
use Cake\I18n\FrozenTime;
use Cake\Utility\Security;
use Firebase\JWT\JWT;

/**
 * Ficha Controller
 *
 * @property \App\Model\Table\FichaTable $Ficha
 *
 * @method \App\Model\Entity\Ficha[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class FichaController extends AppController
{
    public $paginate = [
        'page' => 1,
        'limit' => 10,
        'maxLimit' => 15,
        'fields' => [
            'id', 'fechaCreacion', 'paciente', 'medico'
        ],
        'sortWhitelist' => [
            'id', 'fechaCreacion', 'paciente', 'medico'
        ]
    ];

    public function initialize()
    {
        parent::initialize();
        $this->Auth->allow(['fichas']);
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

        if(($action == "fichas" || $action == "numeroFichas" || $action == "fichasMedico" || $action == "numeroFichasMedico" ||
         $action == "view"  || $action == "getFichaPaciente" || $action == "cambiarMedico" || $action == "delete") && $rol == "administrador"){
            return true;    
        }else if(($action == "fichasMedico" || $action == "numeroFichasMedico" || $action == "view"  || $action == "getFichaPaciente") && $rol == "medico"){
            return true;
        }else if(($action == "viewPaciente") && $rol == "paciente"){
            return true;
        }else{
            return false;
        }
    }

    /* 
    Devuelve una lista con todas las fichas del sistema paginadas
    Solo accesible por el administrador
    */
    public function fichas()
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

                if(isset($data['filtro']['fechaInicio'])){
                    $fechaInicio =  array('fechaCreacion >' => $data['filtro']['fechaInicio']);
                }else{
                    $fechaInicio = "";
                }
                if(isset($data['filtro']['fechaFin'])){
                    $fechaFin =  array('fechaCreacion <' => $data['filtro']['fechaFin']);
                }else{
                    $fechaFin = "";
                }
                if(isset($data['filtro']['id'])){
                    $conditions = array('id' => $data['filtro']['id'],$fechaFin, $fechaFin);
                }else{
                    $conditions = array($fechaInicio, $fechaFin);
                }  

                $condicionesPaciente = array();
                if(isset($data['filtro']['nombrePaciente'])){
                    $nombre = array("u.nombre LIKE" => "%".$data['filtro']['nombrePaciente']."%");
                }else{
                    $nombre = "";
                }  
                if(isset($data['filtro']['apellidosPaciente'])){
                    $apellidos = array("u.apellidos LIKE" => "%".$data['filtro']['apellidosPaciente']."%");
                }else{
                    $apellidos = "";
                }  
                if(isset($data['filtro']['dniPaciente'])){
                    $dniPaciente = array("u.dni LIKE" => "%".$data['filtro']['dniPaciente']."%");
                }else{
                    $dniPaciente = "";
                } 
                $condicionesPaciente = array($nombre, $apellidos, $dniPaciente);
            } 

            $fichas = $this->Ficha->find('all', array('conditions' => $conditions));

            $paginador = $this->paginate($fichas);

            foreach($paginador as $ficha){
                
                $usuarios = TableRegistry::getTableLocator()->get('User');
                $iteradorUsuarios = $usuarios->find()->where(['id' => $ficha['paciente']])->all();
                foreach($iteradorUsuarios as $usuario){
                    $ficha['dniPaciente'] = $usuario['dni'];
                    $ficha['nombrePaciente'] = $usuario['nombre']." ".$usuario['apellidos'];
                }
                $iteradorUsuarios2 = $usuarios->find()->where(['id' => $ficha['medico']])->all();
                foreach($iteradorUsuarios2 as $usuario2){
                    $ficha['dniMedico'] = $usuario2['dni'];
                    $ficha['nombreMedico'] = $usuario2['nombre']." ".$usuario2['apellidos'];
                    $ficha['colegiado'] = $usuario2['colegiado'];
                }
                $enfermedad = TableRegistry::getTableLocator()->get('FichaEnfermedad');
                $iteradorEnfermedad = $enfermedad->find()->where(['ficha' => $ficha['id']])->all();

                foreach($iteradorEnfermedad as $enfermedad){
                    $ficha['enfermedad'] = $enfermedad['enfermedad'];
                }
                $fecha = FrozenTime::parse($ficha->fechaCreacion);
                $ficha->fechaCreacion = $fecha;
                $ficha->fechaCreacion = $ficha->fechaCreacion->i18nFormat('dd/MM/YYYY');
            }
        
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
    Devuelve el numero de fichas del sistema
    Solo acesible por el administrador
    */
    public function numeroFichas()
    {
        $check = $this->checkToken();
        if($check){
            $this->autoRender = false;
            $conditions = array();
            $fichas = $this->Ficha->find('all', array('conditions' => $conditions));

            $i = 0;
            foreach($fichas as $ficha){
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
    Devuelve el la ifnormación de las fichas asignadas a un médico paginadas
    Solo acesible por el administrador y el médico
    */
    public function fichasMedico()
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

            $usuarios2 = TableRegistry::getTableLocator()->get('User');
            $iteradorUsuarios = $usuarios2->find()->where(['username' => $data['medico']])->all();
            foreach($iteradorUsuarios as $user){
                    $idUsuario = $user['id'];
            }

            if(!isset($data['filtro'])){
                $conditions = array('medico' => $idUsuario);
            }else{
                if(isset($data['filtro']['fechaInicio'])){
                    $fechaInicio =  array('fechaCreacion >' => $data['filtro']['fechaInicio']);
                }else{
                    $fechaInicio = "";
                }
                if(isset($data['filtro']['fechaFin'])){
                    $fechaFin =  array('fechaCreacion <' => $data['filtro']['fechaFin']);
                }else{
                    $fechaFin = "";
                }
                if(isset($data['filtro']['id'])){
                    $conditions = array('medico' => $idUsuario,'id' => $data['filtro']['id'],$fechaFin, $fechaFin);
                }else{
                    $conditions = array('medico' => $idUsuario,$fechaInicio, $fechaFin);
                }  
            } 

            $fichas = $this->Ficha->find('all', array('conditions' => $conditions));
            $paginador = $this->paginate($fichas);

            foreach($paginador as $ficha){
                
                $usuarios = TableRegistry::getTableLocator()->get('User');
                $iteradorUsuarios = $usuarios->find()->where(['id' => $ficha['paciente']])->all();
                foreach($iteradorUsuarios as $usuario){
                    $ficha['dniPaciente'] = $usuario['dni'];
                    $ficha['nombrePaciente'] = $usuario['nombre']." ".$usuario['apellidos'];
                }
                $iteradorUsuarios2 = $usuarios->find()->where(['id' => $ficha['medico']])->all();
                foreach($iteradorUsuarios2 as $usuario2){
                    $ficha['dniMedico'] = $usuario2['dni'];
                    $ficha['nombreMedico'] = $usuario2['nombre']." ".$usuario2['apellidos'];
                    $ficha['colegiado'] = $usuario2['colegiado'];
                }
                $enfermedad = TableRegistry::getTableLocator()->get('FichaEnfermedad');
                $iteradorEnfermedad = $enfermedad->find()->where(['ficha' => $ficha['id']])->all();

                foreach($iteradorEnfermedad as $enfermedad){
                    $ficha['enfermedad'] = $enfermedad['enfermedad'];
                }
                $fecha = FrozenTime::parse($ficha->fechaCreacion);
                $ficha->fechaCreacion = $fecha;
                $ficha->fechaCreacion = $ficha->fechaCreacion->i18nFormat('dd/MM/YYYY');
            }
        
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
    Devuelve el número de fichas asignadas a un médico paginadas
    Solo acesible por el administrador y el médico
    */
    public function numeroFichasMedico()
    {
        $check = $this->checkToken();
        if($check){
            $this->autoRender = false;
            $data = $this->request->getData();

            if(isset($data['tipo'])){
                $this->paginate['order'] = [$data['tipo'] => 'desc'];
            }

            $usuarios2 = TableRegistry::getTableLocator()->get('User');
            $iteradorUsuarios = $usuarios2->find()->where(['username' => $data['medico']])->all();
            foreach($iteradorUsuarios as $user){
                    $idUsuario = $user['id'];
            }


            if(!isset($data['filtro'])){
                $conditions = array('medico' => $idUsuario);
            }else{
                if(isset($data['filtro']['fechaInicio'])){
                    $fechaInicio =  array('fechaCreacion >' => $data['filtro']['fechaInicio']);
                }else{
                    $fechaInicio = "";
                }
                if(isset($data['filtro']['fechaFin'])){
                    $fechaFin =  array('fechaCreacion <' => $data['filtro']['fechaFin']);
                }else{
                    $fechaFin = "";
                }
                if(isset($data['filtro']['id'])){
                    $conditions = array('medico' => $idUsuario,'id' => $data['filtro']['id'],$fechaFin, $fechaFin);
                }else{
                    $conditions = array('medico' => $idUsuario,$fechaInicio, $fechaFin);
                }  
            } 

            $fichas = $this->Ficha->find('all', array('conditions' => $conditions));
            $i = 0;
            foreach($fichas as $ficha){
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
    Devuelve la información de una ficha
    Accesible por el médico y por el administrador
    */
    public function view($id = null)
    {
        $check = $this->checkToken();
        if($check){
            $this->autoRender = false;
            $ficha = $this->Ficha->get($id);
            
            $enfermedades = array();

            $fichaEnfermedad = TableRegistry::getTableLocator()->get('FichaEnfermedad');
            $iteradorEnfermedades = $fichaEnfermedad->find()->where(['ficha' => $id])->all();
            $i = 0;
            foreach($iteradorEnfermedades as $enfermedad){
                $enfermedades[$i++] = $enfermedad['enfermedad'];
            }

            $ficha['enfermedad'] = (object) $enfermedades;

            $fecha = FrozenTime::parse($ficha->fechaCreacion);
            $ficha->fechaCreacion = $fecha;
            $ficha->fechaCreacion = $ficha->fechaCreacion->i18nFormat('dd/MM/YYYY');

            $this->response->statusCode(200);
            $this->response->type('json');
            $json = json_encode($ficha);
            $this->response->body($json);
        }else{
            $this->response->statusCode(403);
            $this->response->type('json');
            $json = json_encode("error");
            $this->response->body($json);
        }
    }

    /*
    Devuelve la información de una ficha
    Accesible por el paciente
    */
    public function viewPaciente($id = null)
    {
        $check = $this->checkToken();
        if($check){
            $this->autoRender = false;
            $ficha = $this->Ficha->get($id);
            
            $enfermedades = array();

            $fichaEnfermedad = TableRegistry::getTableLocator()->get('FichaEnfermedad');
            $iteradorEnfermedades = $fichaEnfermedad->find()->select([
                'enfermedad'
            ])->where(['ficha' => $id])->all();
            foreach($iteradorEnfermedades as $enfermedad){
                array_push($enfermedades, $enfermedad);
            }

            $ficha['enfermedad'] = $enfermedades;

            $fecha = FrozenTime::parse($ficha->fechaCreacion);
            $ficha->fechaCreacion = $fecha;
            $ficha->fechaCreacion = $ficha->fechaCreacion->i18nFormat('dd/MM/YYYY');

            $this->response->statusCode(200);
            $this->response->type('json');
            $json = json_encode($ficha);
            $this->response->body($json);
        }else{
            $this->response->statusCode(403);
            $this->response->type('json');
            $json = json_encode("error");
            $this->response->body($json);
        }
    }


    /*
    Devuelve la información de la ficha de un paciente
    Accesible por el médico y por el administrador
    */
    public function getFichaPaciente($id = null)
    {
        $check = $this->checkToken();
        if($check){
            $this->autoRender = false;
            $iteradorFicha = $this->Ficha->find()->where(['paciente' => $id])->all();
            
            foreach($iteradorFicha as $ficha){
                $enfermedades = array();

                $fichaEnfermedad = TableRegistry::getTableLocator()->get('FichaEnfermedad');
                $iteradorEnfermedades = $fichaEnfermedad->find()->where(['ficha' => $ficha['id']])->all();
                $i = 0;
                foreach($iteradorEnfermedades as $enfermedad){
                    $enfermedades[$i++] = $enfermedad['enfermedad'];
                }
        
                $ficha['enfermedad'] = (object) $enfermedades;
        
                $fecha = FrozenTime::parse($ficha->fechaCreacion);
                $ficha->fechaCreacion = $fecha;
                $ficha->fechaCreacion = $ficha->fechaCreacion->i18nFormat('dd/MM/YYYY');
                $fichaAEnviar = array($ficha);
            }

            $this->response->statusCode(200);
            $this->response->type('json');
            $json = json_encode($fichaAEnviar);
            $this->response->body($json);
        }else{
            $this->response->statusCode(403);
            $this->response->type('json');
            $json = json_encode("error");
            $this->response->body($json);
        }
    }


    /*
    Añade una nueva ficha al sistema
    */
    public function add($idUsuario)
    {
        $data['paciente'] = $idUsuario;
        $fecha = FrozenTime::now();
        $data['fechaCreacion'] = $fecha;
        $data['fechaCreacion'] =   $data['fechaCreacion']->i18nFormat('YYYY-mm-dd HH:mm:ss');
        $ficha = $this->Ficha->newEntity();
        $ficha = $this->Ficha->patchEntity($ficha, $data);
        $this->Ficha->save($ficha);
    }

    /*
    permite asignar un medico a un paciente
    solo accesible por el administrador
    */
    public function cambiarMedico()
    {
        $check = $this->checkToken();
        if($check){
            $this->autoRender = false;
            $data = $this->request->getData();
            $ficha = $this->Ficha->get($data['id']);
            if ($this->request->is(['patch', 'post', 'put'])) {
                $ficha = $this->Ficha->patchEntity($ficha, $this->request->getData());
                if ($this->Ficha->save($ficha)) {
                    $this->response->statusCode(200);
                    $this->response->type('json');
                    $json = json_encode($ficha);
                    $this->response->body($json);
                }else{
                    $this->response->statusCode(500);
                    $this->response->type('json');
                    $json = json_encode($ficha->errors());
                    $this->response->body($json);
                }  
            }
        }else{
            $this->response->statusCode(403);
            $this->response->type('json');
            $json = json_encode("error");
            $this->response->body($json);
        }
    }

    /*
    Permite eliminar una ficha
    Solo accesible por el administrador
    */
    public function delete($id = null)
    { 
        $check = $this->checkToken();
        if($check){
            $this->autoRender = false;
            $ficha = $this->Ficha->get($id);
            $this->Ficha->delete($ficha);

            $this->response->statusCode(200);
            $this->response->type('json');
            $json = json_encode($ficha);
            $this->response->body($json);
        }else{
            $this->response->statusCode(403);
            $this->response->type('json');
            $json = json_encode("error");
            $this->response->body($json);
        }
    }
}
