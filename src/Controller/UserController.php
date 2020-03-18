<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;
use Cake\Event\Event;
use Cake\Mailer\Email;
use Cake\Mailer\TransportFactory;
use Cake\I18n\FrozenTime;


/**
 * User Controller
 *
 * @property \App\Model\Table\UserTable $User
 *
 * @method \App\Model\Entity\User[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class UserController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function initialize()
    {
        parent::initialize();
        $this->Auth->allow(['register', 'login', 'confirmar', 'usuarios', 'logout', 'delete', 
        'view', 'registerMedico', 'todosMedicos', 'edit', 'editarEspecialidad', 'editarUser',
         'userActivados', 'longitudUserActivados', 'autorizar', 'loginPaciente', 'registerPaciente']);
        $this->loadComponent('Csrf');
    }

    public function beforeFilter(Event $event) {
        
            $this->eventManager()->off($this->Csrf);
        
    }


    /*
    public function isAuthorized($user)
    {
        // Los usuarios no administradores solo pueden ver su perfil, editarlo
        // y desconectarse
        return in_array($this->getRequest()->getParam('action'), ['view', 'edit', 'logout']) ||
               $user['rol'] === 'administrador';
    }
    */


    public function usuarios()
    {
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

    public function logout(){
        $this->autoRender = false;
        $this->Auth->logout();
        $this->response->statusCode(200);
        $this->response->type('json');
        $this->set('respuesta', 'Has cerrado sesion correctamente');   
        $this->set('_serialize', ['respuesta']); 
    }

    /**
     * View method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
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
        $user->nacimiento = $user->nacimiento->i18nFormat('dd/MM/YYYY');
        $this->response->statusCode(200);
        $this->response->type('json');
        $json = json_encode($user);
        $this->response->body($json);
    }

    public function todosMedicos()
    {
        $this->autoRender = false;
        $usuarios = $this->User->find()->all();
        $usuarioFinal = array();
        $i=0;

        foreach($usuarios as $usuario){
            $cuenta = TableRegistry::getTableLocator()->get('Cuenta');
            $iteradorCuentas = $cuenta->find()->where(['user' => $usuario['id']])->all();
            foreach($iteradorCuentas as $cuenta){
                $usuario['rol'] = $cuenta['rol'];
                if($usuario['rol'] == "medico"){
                  $usuarioFinal[$i++] = $usuario;  
                }
            }
        }

        $this->response->statusCode(200);
        $this->response->type('json');
        $json = json_encode($usuarioFinal);
        $this->response->body($json);
    }
    

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $user = $this->User->newEntity();
        if ($this->request->is('post')) {
            $user = $this->User->patchEntity($user, $this->request->getData());
            if ($this->User->save($user)) {
                $this->Flash->success(__('The user has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The user could not be saved. Please, try again.'));
        }
        $this->set(compact('user'));
    }

    /**
     * Edit method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
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
            }
        $this->response->statusCode(200);
        $this->response->type('json');
        $json = json_encode($user2);
        $this->response->body($json);
    }
    /**
     * Delete method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['delete']);
        $usuario = $this->User->get($id);

        $cuentas = TableRegistry::getTableLocator()->get('Cuenta');
        $iteradorCuentaUsuario = $cuentas->find()->where(['user' => $id])->all();
        foreach($iteradorCuentaUsuario as $cuentaUsuario){
            $idCuenta = $cuentaUsuario['id'];
        }

        if ($this->User->delete($usuario)) {
            $this->response->statusCode(200);
            $this->response->type('json');
            $this->set('respuesta', 'Se ha eliminado correctamente');   
            $this->set('_serialize', ['respuesta']);
        } else {
            $this->response->statusCode(500);
            $this->response->type('json');
            $this->set('respuesta', 'No se ha eliminado el usuario');   
            $this->set('_serialize', ['respuesta']);
        }
    }

    public function login()
    {   
        $this->autoRender = false;
        $username =  env('PHP_AUTH_USER');
        $pass = env('PHP_AUTH_PW');
        $userRaw = $this->User->find('all', array(
            'conditions' => array('User.username' => $username),
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
                $this->set('problema', 'El administrador aun no te ha autorizado');    
                $this->set('_serialize', ['problema']); 
            }else{
                if($user['password'] !== $pass) {
                    header('Access-Control-Allow-Origin: *');
                    $this->response->statusCode(403);
                    header('Content-Type: application/json');
                    $this->set('problema', 'Las credenciales son incorrectas');    
                    $this->set('_serialize', ['problema']); 
                }
                else{
                    $this->Auth->setUser($user);
                    $this->response->statusCode(200);
                    $this->response->type('json');
                    $json = json_encode($user);
                    $this->response->body($json);
                } 
            }    
        }
    }

    public function loginPaciente()
    {   
        $this->autoRender = false;
        $username =  env('PHP_AUTH_USER');
        $pass = env('PHP_AUTH_PW');
        $userRaw = $this->User->find('all', array(
            'conditions' => array('User.username' => $username),
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
                $this->set('problema', 'El administrador aun no te ha autorizado');    
                $this->set('_serialize', ['problema']); 
            }else{
                if($user['password'] !== $pass) {
                    header('Access-Control-Allow-Origin: *');
                    $this->response->statusCode(403);
                    header('Content-Type: application/json');
                    $this->set('problema', 'Las credenciales son incorrectas');    
                    $this->set('_serialize', ['problema']); 
                }
                else if($estadoCuenta == "autorizada" && $rol == "paciente" ){
                    unset($user['colegiado']);
                    unset($user['cargo']);
                    unset($user['especialidad']);
                    $this->Auth->setUser($user);
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


    public function register()
    {
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

    public function registerMedico()
    {
        
        $this->autoRender = false;
        $user = $this->User->newEntity($this->request->data);

        if ($this->User->save($user)){  

            $iterador = $this->User->find()->where(['username' => $user['username']])->all();
            foreach($iterador as $usuario){
                $idUsuario = $usuario['id'];                
            }
                 
                $datosCuenta = array();
                $datosCuenta['rol'] = "medico";
                $datosCuenta['estado'] = "autorizada";
                $datosCuenta['user'] = $idUsuario;
                $user['estado'] = "autorizada";

                $cuenta = (new CuentaController());
                $cuenta->add($datosCuenta);

                header('Access-Control-Allow-Origin: *');
                header($_SERVER['SERVER_PROTOCOL'].' 200 Ok');
                header('Content-Type: application/json; charset=utf-8');
                $this->set('UsuarioCreado', $user); 
                $this->set('_serialize', ['UsuarioCreado']); 

        }else{
            header('Access-Control-Allow-Origin: *');
            header($_SERVER['SERVER_PROTOCOL'].' 200 Ok');
            header('Content-Type: application/json; charset=utf-8');
            $this->set('UsuarioCreado', 'Error al crear el usuario'); 
            $this->set('_serialize', ['UsuarioCreado']);  
        }  

    }

    public function registerPaciente()
    {
        
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
            }
                 
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
                $this->response->statusCode(500);
                $this->response->type('json');
                $json = json_encode($error);
                $this->response->body($json);
        } 

    }

    public function confirmar($id = null)
    {
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

    public function userActivados()
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
}
