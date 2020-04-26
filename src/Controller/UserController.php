<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;
use Cake\Event\Event;
use Cake\Mailer\Email;
use Cake\Mailer\TransportFactory;
use Cake\I18n\FrozenTime;
use Cake\Auth\DefaultPasswordHasher;
use Cake\Network\Exception\UnauthorizedException;
use Cake\Utility\Security;
use Firebase\JWT\JWT;


/**
 * User Controller
 *
 * @property \App\Model\Table\UserTable $User
 *
 * @method \App\Model\Entity\User[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */

class UserController extends AppController
{

    /*Función que inicializa el componente
      define las acciones que pueden ser accesibles si el usuario no esta registrado
    */

    public $paginate = [
        'page' => 1,
        'limit' => 10,
        'maxLimit' => 15,
        'sortWhitelist' => [
            'dni', 'nombre', 'email', 'telefono'
        ]
    ];

    public function initialize(){
        parent::initialize();
        $this->Auth->allow(['register', 'login','loginPaciente', 'registerPaciente', 'confirmar', 'getLoggedUser']);
    }

    public function getLoggedUser($id){
        $this->autoRender = false;
        $this->response->statusCode(200);
        $user = $this->User->get($id, [
            'contain' => [],
        ]);
        $this->response->type('json');
        $array['funciona'] = Security::encrypt("pene",  Security::salt());
        $json = json_encode($array);
        $this->response->body($json);
    }

    /*
    funcion que devulve los medicos según una página especificada
    */
    public function getMedicos(){
        $this->autoRender = false;
            $data = $this->request->getData();
            $this->paginate['page'] = $data['page']+1;
            $this->paginate['limit'] = $data['limit'];
            if(isset($data['tipo'])){
                $this->paginate['order'] = [$data['tipo'] => 'desc'];
            }

            $usuario = $this->User->find('all')->join([
                'table' => 'cuenta',
                'alias' => 'c',
                'type' => 'INNER',
                'conditions' => ['c.user = user.id',
                'c.rol' => 'medico']
            ]);

            $paginador = $this->paginate($usuario);
            foreach($paginador as $user){
                $cuenta = TableRegistry::getTableLocator()->get('Cuenta');
                $iteradorCuentas = $cuenta->find()->where(['user' => $user['id']])->all();
                foreach($iteradorCuentas as $cuenta){
                    $user['rol'] = $cuenta['rol'];
                    $user['estado'] = $cuenta['estado'];
                }
            }

            $this->response->statusCode(200);
            $this->response->type('json');
            $json = json_encode($paginador);
            $this->response->body($json);
    }

    /*
    funcion que devulve los administradores según una página especificada
    */
    public function getAdministradores(){
        $this->autoRender = false;
            $data = $this->request->getData();
            $this->paginate['page'] = $data['page']+1;
            $this->paginate['limit'] = $data['limit'];
            if(isset($data['tipo'])){
                $this->paginate['order'] = [$data['tipo'] => 'desc'];
            }

            $usuario = $this->User->find('all')->join([
                'table' => 'cuenta',
                'alias' => 'c',
                'type' => 'INNER',
                'conditions' => ['c.user = user.id',
                'c.rol' => 'administrador']
            ]);

            $paginador = $this->paginate($usuario);
            foreach($paginador as $user){
                $cuenta = TableRegistry::getTableLocator()->get('Cuenta');
                $iteradorCuentas = $cuenta->find()->where(['user' => $user['id']])->all();
                foreach($iteradorCuentas as $cuenta){
                    $user['rol'] = $cuenta['rol'];
                    $user['estado'] = $cuenta['estado'];
                }
            }
            $this->response->statusCode(200);
            $this->response->type('json');
            $json = json_encode($paginador);
            $this->response->body($json);
    }

    /*
    funcion que devulve los pacientes según una página especificada
    */
    public function getPacientes(){
        $this->autoRender = false;
            $data = $this->request->getData();
            $this->paginate['page'] = $data['page']+1;
            $this->paginate['limit'] = $data['limit'];
            if(isset($data['tipo'])){
                $this->paginate['order'] = [$data['tipo'] => 'desc'];
            }

            $usuario = $this->User->find('all')->join([
                'table' => 'cuenta',
                'alias' => 'c',
                'type' => 'INNER',
                'conditions' => ['c.user = user.id',
                'c.rol' => 'paciente']
            ]);

            $paginador = $this->paginate($usuario);
            foreach($paginador as $user){
                $cuenta = TableRegistry::getTableLocator()->get('Cuenta');
                $iteradorCuentas = $cuenta->find()->where(['user' => $user['id']])->all();
                foreach($iteradorCuentas as $cuenta){
                    $user['rol'] = $cuenta['rol'];
                    $user['estado'] = $cuenta['estado'];
                }
            }
            
            $this->response->statusCode(200);
            $this->response->type('json');
            $json = json_encode($paginador);
            $this->response->body($json);
    }

    /*
    funcion que devuelve el número de administradores
    */
    public function getNumeroAdministradores(){
        $this->request->allowMethod(['get']);
        $this->autoRender = false;
            $data = $this->request->getData();
            if(isset($data['tipo'])){
                $this->paginate['order'] = [$data['tipo'] => 'desc'];
            }
    
            $usuario = $this->User->find('all')->join([
                'table' => 'cuenta',
                'alias' => 'c',
                'type' => 'INNER',
                'conditions' => ['c.user = user.id',
                'c.rol' => 'administrador']
            ]);
            $i = 0;
    
            foreach($usuario as $user){
                $i++;
            }
    
            $myObj = array();
            $myObj['numero'] = $i;
            
            $this->response->statusCode(200);
            $this->response->type('json');
            $json = json_encode($myObj);
            $this->response->body($json);
    }

    /*
    funcion que devuelve el número de medicos
    */
    public function getNumeroMedicos(){
        $this->autoRender = false;
        $data = $this->request->getData();
            if(isset($data['tipo'])){
                $this->paginate['order'] = [$data['tipo'] => 'desc'];
            }

            $usuario = $this->User->find('all')->join([
                'table' => 'cuenta',
                'alias' => 'c',
                'type' => 'INNER',
                'conditions' => ['c.user = user.id',
                'c.rol' => 'medico']
            ]);

            $i = 0;

            foreach($usuario as $user){
                $i++;
            }

            $myObj = array();
            $myObj['numero'] = $i;
            
            $this->response->statusCode(200);
            $this->response->type('json');
            $json = json_encode($myObj);
            $this->response->body($json);
    }

    /*
    funcion que devuelve el número de pacientes
    */
    public function getNumeroPacientes(){
        $this->autoRender = false;
            $data = $this->request->getData();
            if(isset($data['tipo'])){
                $this->paginate['order'] = [$data['tipo'] => 'desc'];
            }

            $usuario = $this->User->find('all')->join([
                'table' => 'cuenta',
                'alias' => 'c',
                'type' => 'INNER',
                'conditions' => ['c.user = user.id',
                'c.rol' => 'paciente']
            ]);

            $i = 0;

            foreach($usuario as $user){
                $i++;
            }

            $myObj = array();
            $myObj['numero'] = $i;
            
            $this->response->statusCode(200);
            $this->response->type('json');
            $json = json_encode($myObj);
            $this->response->body($json);
    }

    /*
    Función que devuelve todos los usuarios existentes en el sistema
    Solo accesible por el administrador
    */
    public function usuarios(){
        $this->autoRender = false;
            $usuarios = $this->User->find()->all();

            foreach($usuarios as $usuario){
                $cuenta = TableRegistry::getTableLocator()->get('Cuenta');
                $iteradorCuentas = $cuenta->find()->where(['user' => $usuario['id']])->all();
                foreach($iteradorCuentas as $cuenta){
                    $usuario['rol'] = $cuenta['rol'];
                    $usuario['estado'] = $cuenta['estado'];
                }
            }

            $this->response->statusCode(200);
            $this->response->type('json');
            $json = json_encode($usuarios);
            $this->response->body($json);
    }

    /*
    Función que cierra sesión del usuario
    Accesible por el administrador, médico y paciente
    */
    public function logout($id = null){
        $this->desactivarUser($id);
        $this->autoRender = false;
        $this->Auth->logout();
        $respuesta = array('respuesta' => "Has cerrado sesion correctamente");
        $this->response->statusCode(200);
        $this->response->type('json');
        $json = json_encode($respuesta);
        $this->response->body($json);
    }

    /*
    Función que devuelve los datos de un usuario según su id
    También devuelve los datos asociados a su cuenta
    Accesible por el administrador, médico y paciente
    */
    public function view($id = null)
    {

        $this->autoRender = false;
            $user = $this->User->get($id, [
                'contain' => [],
            ]);

            $cuenta = TableRegistry::getTableLocator()->get('Cuenta');
                $iteradorCuentas = $cuenta->find()->where(['user' => $user->id])->all();
                foreach($iteradorCuentas as $cuenta){
                    $user['rol'] = $cuenta['rol'];
                    $user['estado'] = $cuenta['estado'];
                }
            
            $ficha = TableRegistry::getTableLocator()->get('Ficha');
            if($user['rol'] == "medico"){
                $iteradorFicha = $ficha->find()->where(['medico' => $user->id])->all();
                foreach($iteradorFicha as $ficha){
                    $user['pacienteAcargo'] = $ficha['paciente'];
                    $user['medicoEncargado'] = null;
                }
            }
            if($user['rol'] == "paciente"){
                $iteradorFicha = $ficha->find()->where(['paciente' => $user->id])->all();
                foreach($iteradorFicha as $ficha){
                    $user['pacienteAcargo'] = null;
                    $user['medicoEncargado'] = $ficha['medico'];
                }
            }

            $fecha = FrozenTime::parse($user->nacimiento);
            $user->nacimiento = $fecha;
            $user->nacimiento = $user->nacimiento->i18nFormat('dd-MM-YYYY');

            $this->response->statusCode(200);
            $this->response->type('json');
            $json = json_encode($user);
            $this->response->body($json);
    }

    /*
    Función que devuelve los datos de todos los médicos existentes en la aplicación
    Solo accesible por el administrador
    */
    public function todosMedicos(){
        $this->autoRender = false;


            $usuario = $this->User->find('all')->join([
                'table' => 'cuenta',
                'alias' => 'c',
                'type' => 'INNER',
                'conditions' => ['c.user = user.id',
                'c.rol' => 'medico']
            ]);


            $this->response->statusCode(200);
            $this->response->type('json');
            $json = json_encode($usuario);
            $this->response->body($json);
    }

    /*
    Función que autoriza la cuenta asociada al id de un usuario
    Solo accesible por el administrador
    */
    public function autorizar($id = null)
    {
        $this->autoRender = false;
            $cuenta = TableRegistry::getTableLocator()->get('Cuenta');
                $iteradorCuentas = $cuenta->find()->where(['user' => $id])->all();
                foreach($iteradorCuentas as $cuenta){
                    $idCuenta= $cuenta['id'];
                }

            $cuenta = (new CuentaController());
            $cuenta->edit3($idCuenta);

            $this->response->statusCode(200);
            $this->response->type('json');
            $json = json_encode($id);
            $this->response->body($json);
    }


    /*
    Función que edita los datos del usuario
    Accesible por el administrador, médico y paciente
    */
    public function editarUser()
    {
        $this->autoRender = false;
            $data = $this->request->getData();
            
            $user = $this->User->get($data['id'], [
                'contain' => [],
            ]);
        
                $user2 = $this->User->patchEntity($user, $data);
                if ($this->User->save($user2)) {
                    $this->response->statusCode(200);
                    $this->response->type('json');
                    $json = json_encode($user2);
                    $this->response->body($json);
                }else{
                    $this->response->statusCode(500);
                    $this->response->type('json');
                    $json = json_encode($user2->errors());
                    $this->response->body($json);
                }     
    }

    public function activarUser($id = null)
    {
        $this->autoRender = false;
            $data['active'] = true;
            
            $user = $this->User->get($id, [
                'contain' => [],
            ]);
        
                $user2 = $this->User->patchEntity($user, $data);
                if ($this->User->save($user2)) {
                    $this->response->statusCode(200);
                    $this->response->type('json');
                    $json = json_encode($user2);
                    $this->response->body($json);
                }else{
                    $this->response->statusCode(500);
                    $this->response->type('json');
                    $json = json_encode($user2->errors());
                    $this->response->body($json);
                }     
    }

    public function desactivarUser($id = null)
    {
        $this->autoRender = false;
            $data['active'] = false;
            
            $user = $this->User->get($id, [
                'contain' => [],
            ]);
        
                $user2 = $this->User->patchEntity($user, $data);
                if ($this->User->save($user2)) {
                    $this->response->statusCode(200);
                    $this->response->type('json');
                    $json = json_encode($user2);
                    $this->response->body($json);
                }else{
                    $this->response->statusCode(500);
                    $this->response->type('json');
                    $json = json_encode($user2->errors());
                    $this->response->body($json);
                }     
    }

    

    /*
    Función que elimina un usuario del sistema
    Accesible por el administrador, médico y paciente
    */
    public function delete($idUser = null)
    {
        $this->autoRender = false;
            $user = $this->User->find()->where(['id' => $idUser])->all();
            foreach($user as $user){
                $id = $user['id'];
            }
            $userAEliminar = $this->User->get($id);
            $this->User->delete($userAEliminar);
            $this->response->statusCode(200);
            $this->response->type('json');
            $json = json_encode($userAEliminar);
            $this->response->body($json);
    }

    /*
    Función que permite hacer login a un administrador o médico
    Accesible por el administrador y médico
    */
    public function login()
    {   
        $this->autoRender = false;
        $data = $this->request->getData();
        $userRaw = $this->User->find('all', array(
            'conditions' => array('User.username' => $data['username']),
        ));

        foreach($userRaw as $user){
            $user = $user;
            $idUser = $user['id'];
        }

        if(!isset($idUser)){
            $this->response->statusCode(403);
            header('Access-Control-Allow-Origin: *');
            header('Content-Type: application/json');
            $this->set('problema', 'El usuario aun no esta registrado');    
            $this->set('_serialize', ['problema']); 
        }else{
            foreach($userRaw as $user){
                $user = $user;
                $idUser = $user['id'];
            }
            $cuentas = TableRegistry::getTableLocator()->get('Cuenta');
            $iteradorCuentaUsuario = $cuentas->find()->where(['user' => $idUser])->all();
            foreach($iteradorCuentaUsuario as $cuentaUsuario){
                $estadoCuenta = $cuentaUsuario['estado'];
                $rol = $cuentaUsuario['rol'];
            }

            $user['rol'] = $rol;

            if($estadoCuenta == "desactivada"){
                header('Access-Control-Allow-Origin: *');
                $this->response->statusCode(403);
                header('Content-Type: application/json');
                $this->set('problema', 'Aun no has activado tu cuenta en el e-mail');    
                $this->set('_serialize', ['problema']); 
            }else if($estadoCuenta == "activada"){
                header('Access-Control-Allow-Origin: *');
                $this->response->statusCode(403);
                header('Content-Type: application/json');
                $this->set('problema', 'El administrador aun no te ha isAuthorized');    
                $this->set('_serialize', ['problema']); 
            }else{
                if(!(new DefaultPasswordHasher)->check($data['password'], $user['password'])) {
                    $this->response->statusCode(403);
                    $this->response->type('json');
                    $json = json_encode(array('error'));
                    $this->response->body($json);
                }
                else{
                    if($rol == "administrador" || $rol == "medico" ){
                        $this->activarUser($user['id']);
                        $this->response->statusCode(200);
                        $this->response->type('json');
                        $user['token'] = JWT::encode(
                            [
                                'sub' => $user['id'],
                                'exp' =>  time() + 604800
                            ],
                        Security::salt());
                        $json = json_encode($user);
                        $this->response->body($json);
                    }else{
                        header('Access-Control-Allow-Origin: *');
                        $this->response->statusCode(403);
                        header('Content-Type: application/json');
                        $this->set('problema', 'Las credenciales son incorrectas');    
                        $this->set('_serialize', ['problema']); 
                    }
                } 
            }    
        }
    }

    /*
    Función que permite hacer login a un paciente
    Accesible por el paciente
    */
    public function loginPaciente()
    {   
        $this->autoRender = false;
        $data = $this->request->getData();
        $userRaw = $this->User->find('all', array(
            'conditions' => array('User.username' => $data['username']),
        ));

        foreach($userRaw as $user){
            $user = $user;
            $idUser = $user['id'];
            $fecha = FrozenTime::parse($user['nacimiento']);
            $user->nacimiento = $fecha;
            $user->nacimiento =  $user->nacimiento->i18nFormat('dd/MM/YYYY HH:mm:ss');
        }

        if(!isset($idUser)){
            $this->response->statusCode(403);
            header('Access-Control-Allow-Origin: *');
            header('Content-Type: application/json');
            $this->set('problema', 'El usuario aun no esta registrado');    
            $this->set('_serialize', ['problema']); 
        }else{
            foreach($userRaw as $user){
                $user = $user;
                $idUser = $user['id'];
            }
            $cuentas = TableRegistry::getTableLocator()->get('Cuenta');
            $iteradorCuentaUsuario = $cuentas->find()->where(['user' => $idUser])->all();
            foreach($iteradorCuentaUsuario as $cuentaUsuario){
                $estadoCuenta = $cuentaUsuario['estado'];
                $rol = $cuentaUsuario['rol'];
            }

            $fichas = TableRegistry::getTableLocator()->get('Ficha');
            $iteradorfichaUsuario = $fichas->find()->where(['paciente' => $idUser])->all();

            foreach($iteradorfichaUsuario as $fichaUsuario){
                $idFicha = $fichaUsuario['id'];
            }

            $user['rol'] = $rol;
            $user['ficha'] = $idFicha;
    
            if($estadoCuenta == "desactivada"){
                header('Access-Control-Allow-Origin: *');
                $this->response->statusCode(403);
                header('Content-Type: application/json');
                $this->set('problema', 'Aun no has activado tu cuenta en el e-mail');    
                $this->set('_serialize', ['problema']); 
            }else if($estadoCuenta == "activada"){
                header('Access-Control-Allow-Origin: *');
                $this->response->statusCode(403);
                header('Content-Type: application/json');
                $this->set('problema', 'El administrador aun no te ha isAuthorized');    
                $this->set('_serialize', ['problema']); 
            }else{
                if(!(new DefaultPasswordHasher)->check($data['password'], $user['password'])) {
                    header('Access-Control-Allow-Origin: *');
                    $this->response->statusCode(403);
                    header('Content-Type: application/json');
                    $this->set('problema', 'Las credenciales son incorrectas');    
                    $this->set('_serialize', ['problema']); 
                }
                else if($estadoCuenta == "autorizada" && $rol == "paciente" ){
                    $this->activarUser($user['id']);
                    $user['token'] = JWT::encode(
                        [
                            'sub' => $user['id'],
                            'exp' =>  time() + 604800
                        ],
                    Security::salt());
                    unset($user['colegiado']);
                    unset($user['cargo']);
                    unset($user['especialidad']);
                    $this->response->statusCode(200);
                    $this->response->type('json');
                    $json = json_encode($user);
                    $this->response->body($json);
                }
                else{
                    header('Access-Control-Allow-Origin: *');
                    $this->response->statusCode(403);
                    header('Content-Type: application/json');
                    $this->set('problema', 'Las credenciales son incorrectas');    
                    $this->set('_serialize', ['problema']); 
                }
            }    
        }
    }

    /*
    Función que permite registrar a un médico sin autorizar la cuenta
    Accesible por el médico
    */
    public function register()
    {
        $this->request->allowMethod(['post']);
        $this->autoRender = false;
        $user = $this->User->newEntity($this->request->data);

        if ($this->User->save($user)){  

            $iterador = $this->User->find()->where(['username' => $user['username']])->all();
            foreach($iterador as $usuario){
                $idUsuario = $usuario['id'];
                $emailUsuario =  $usuario['email'];
            }

            TransportFactory::setConfig('mailtrap', [
                'host' => 'smtp.mailtrap.io',
                'port' => 2525,
                'username' => '8bf4341c41b90b',
                'password' => '7ebfbfaa262629',
                'className' => 'Smtp'
              ]);

                $email = new Email();
                $email->transport('mailtrap');
                $email->emailFormat('html');
                $email->from('ssec@ssec.esei.es', 'SSEC');
                $email->subject('Nueva Cuenta Asociada al usuario '. $user['username']);
                $email->to($emailUsuario);
                $email->send('<h3> Hola, se ha creado una nueva cuenta asociada al usuario '.$user['username'].'</h3> <br>
                 <a href="http://localhost:8765/user/confirmar/'.$idUsuario.'.json">Haz click aquí para activarla</a> <br>
                 Para poder usarla el administrador tendrá que aprobar la solicitud después de haber activado la cuenta <br> <br>
                 <h4> SSEC </h4>');  
                 
                $datosCuenta = array();
                $datosCuenta['rol'] = "medico";
                $datosCuenta['estado'] = "desactivada";
                $datosCuenta['user'] = $idUsuario;

                $cuenta = (new CuentaController());
                $cuenta->add($datosCuenta);

                $this->response->statusCode(200);
                $this->response->type('json');
                $this->set('respuesta', $user);   
                $this->set('_serialize', ['respuesta']);

        }else{

            $this->response->statusCode(500);
            $this->response->type('json');
            $this->set('respuesta', 'Error al crear el usuario');   
            $this->set('_serialize', ['respuesta']);

        }  
    }

    /*
    Función que permite registrar a un paciente sin autorizar
    Accesible por el paciente
    */
    public function registerPaciente()
    {
        $this->request->allowMethod(['post']);   
        $this->autoRender = false;
        $data = $this->request->getData();
        $data['id'] = null;
        
        $user = $this->User->newEntity();
        $user = $this->User->patchEntity($user, $data);

        $error = array();
        $error['error'] = "no se puedo crear el usuario";

        if ($this->User->save($user)){  

            $iterador = $this->User->find()->where(['username' => $user['username']])->all();
            foreach($iterador as $usuario){
                $idUsuario = $usuario['id']; 
                $emailUsuario =  $usuario['email'];               
            }

            TransportFactory::setConfig('mailtrap', [
                'host' => 'smtp.mailtrap.io',
                'port' => 2525,
                'username' => '8bf4341c41b90b',
                'password' => '7ebfbfaa262629',
                'className' => 'Smtp'
              ]);

                $email = new Email();
                $email->transport('mailtrap');
                $email->emailFormat('html');
                $email->from('ssec@ssec.esei.es', 'SSEC');
                $email->subject('Nueva Cuenta Asociada al usuario '. $user['username']);
                $email->to($emailUsuario);
                $email->send('<h3> Hola, se ha creado una nueva cuenta asociada al usuario '.$user['username'].'</h3> <br>
                 <a href="http://localhost:8765/user/confirmar/'.$idUsuario.'.json">Haz click aquí para activarla</a> <br>
                 Para poder usarla el administrador tendrá que aprobar la solicitud después de haber activado la cuenta <br> <br>
                 <h4> SSEC </h4>');  
                 
                $datosCuenta = array();
                $datosCuenta['rol'] = "paciente";
                $datosCuenta['estado'] = "desactivada";
                $datosCuenta['user'] = $idUsuario;
                $user['estado'] = "desactivada";

                $cuenta = (new CuentaController());
                $cuenta->add($datosCuenta);

                $this->response->statusCode(200);
                $this->response->type('json');
                $json = json_encode($user);
                $this->response->body($json);

        }else{
                $this->response->statusCode(200);
                $this->response->type('json');
                $json = json_encode($user->errors());
                $this->response->body($json);
        } 
    }

    /*
    Función que confirma el correo de un médico y activa su cuenta
    Accesible por el médico
    */
    public function confirmar($id = null)
    {
        $this->request->allowMethod(['get']);
        $cuentas = TableRegistry::getTableLocator()->get('Cuenta');
        $iteradorCuentaUsuario = $cuentas->find()->where(['user' => $id])->all();
        foreach($iteradorCuentaUsuario as $cuentaUsuario){
            $idCuenta = $cuentaUsuario['id'];
        }
        $cuentaController = (new CuentaController());
        $cuentaController->edit2($idCuenta);

        header('Access-Control-Allow-Origin: *');
        header($_SERVER['SERVER_PROTOCOL'].' 200 Ok');
        header('Content-Type: application/json; charset=utf-8');
        $this->set('UsuarioCreado', $idCuenta);   
        $this->set('_serialize', ['UsuarioCreado']); 
    }

    /*
    Función que devuelve los datos de los usuarios que tengas una cuenta en estado activado
    Accesible por el administrador
    */
    public function userActivados()
    {
            $this->request->allowMethod(['get']);
            $this->autoRender = false;
            $usuarios = $this->User->find()->all();
            $usuarioFinal = array();
            $i=0;

            foreach($usuarios as $usuario){
                $cuenta = TableRegistry::getTableLocator()->get('Cuenta');
                $iteradorCuentas = $cuenta->find()->where(['user' => $usuario['id']])->all();
                foreach($iteradorCuentas as $cuenta){
                    if($cuenta['estado'] == "activada"){
                        $usuario['rol'] = $cuenta['rol'];
                        $usuarioFinal[$i++] = $usuario;  
                    }
                }
            }

            $this->response->statusCode(200);
            $this->response->type('json');
            $json = json_encode($usuarioFinal);
            $this->response->body($json);
    }


    /*
    Función que devuelve el número de usuarios activados
    Accesible por el administrador
    */
    public function longitudUserActivados()
    {
        $this->autoRender = false;
            
            $usuarios = $this->User->find()->all();
            $usuarioFinal = array();
            $i=0;

            foreach($usuarios as $usuario){
                $cuenta = TableRegistry::getTableLocator()->get('Cuenta');
                $iteradorCuentas = $cuenta->find()->where(['user' => $usuario['id']])->all();
                foreach($iteradorCuentas as $cuenta){
                    if($cuenta['estado'] == "activada"){
                        $usuarioFinal[$i++] = $usuario;  
                    }
                }
            }
            $longitud = sizeof($usuarioFinal);

            $this->response->statusCode(200);
            $this->response->type('json');
            $json = json_encode($longitud);
            $this->response->body($json);
    }

    /*
    Cambia el estado de la cuenta de un usuario
    */
    public function editCuentaEstado()
    {
            $this->request->allowMethod(['post']);
            $this->autoRender = false;
            $data = $this->request->getData();
            $cuenta = TableRegistry::getTableLocator()->get('Cuenta');
            $iteradorCuentas = $cuenta->find()->where(['user' => $data['id']])->all();

            foreach($iteradorCuentas as $cuenta){
                $idCuenta = $cuenta['id'];
            }

            $cuentaController = (new CuentaController());
            $cuentaController->edit($idCuenta, $data['valorCuenta'] );
    
            $this->response->statusCode(200);
            $this->response->type('json');
            $json = json_encode($data);
            $this->response->body($json);
    }


    public function token()
    {
        $data = $this->request->getData();
        $userRaw = $this->User->find('all', array(
            'conditions' => array('User.username' => $data['username']),
        ));

        foreach($userRaw as $user){
            $user = $user;
        }
        if(!(new DefaultPasswordHasher)->check($data['password'], $user['password'])){
            $this->autoRender = false;
            $this->response->statusCode(403);
            $this->response->type('json');
            $json = json_encode($data);
            $this->response->body($json);
        }else{
            $this->set([
                'success' => true,
                'data' => [
                    'token' => JWT::encode([
                        'sub' => $user['id'],
                        'exp' =>  time() + 604800
                    ],
                    Security::salt())
                ],
                '_serialize' => ['success', 'data']
            ]);
        }
    }
}
