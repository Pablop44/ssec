<?php
namespace App\Controller;

use App\Controller\AppController;

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

        $this->Auth->allow(['register', 'login']);
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


    public function index()
    {
        $user = $this->User->find('all');
        $this->set(array('user' => $user, '_serialize' => array('user')));
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
        $user = $this->User->get($id, [
            'contain' => [],
        ]);

        $this->set(array('user' => $user, '_serialize' => array('user')));
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
    public function edit($id = null)
    {
        $user = $this->User->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
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
     * Delete method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $user = $this->User->get($id);
        if ($this->User->delete($user)) {
            $this->Flash->success(__('The user has been deleted.'));
        } else {
            $this->Flash->error(__('The user could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function login()
    {   
        $username =  env('PHP_AUTH_USER');
        $pass = env('PHP_AUTH_PW');
        $userRaw = $this->User->find('all', array(
            'conditions' => array('User.username' => $username),
        ));

        foreach($userRaw as $user){
            $user = $user;
        }

        if($user['password'] !== $pass) {
            header('Access-Control-Allow-Origin: *');
            header($_SERVER['SERVER_PROTOCOL'].' 403 Forbidden');
            $this->set('problema', 'No estas autorizado');    
            $this->set('_serialize', ['problema']); 
        }
        else{
            $this->Auth->setUser($user);
            header('Access-Control-Allow-Origin: *');
            header($_SERVER['SERVER_PROTOCOL'].' 200 Ok');
            header('Content-Type: application/json');
            $this->set('user', $user);    
            $this->set('_serialize', ['user']); 
        }    
    }


    public function register()
    {
        $usuario = $this->Usuario->newEntity();

        if ($this->getRequest()->is('post')) {
            /** @var array */
            $data = $this->getRequest()->getData();

            $data['rol'] = 'deportista';
            $data['esSocio'] = '0';
            if (isset($data['password']) && is_string($data['password'])) {
                if (empty($data['password'])) {
                    unset($data['password']);
                } else {
                    $data['password'] = $this->hashPassword($data['password']);
                }
            }

            $usuario = $this->Usuario->patchEntity($usuario, $data);
            if ($this->Usuario->save($usuario)) {
                $this->Flash->success(__("¡Bienvenido a PadeGest, {0}!", $usuario->nombre_completo));
                $this->Auth->setUser($usuario);

                return $this->redirect($this->Auth->redirectUrl());
            } else {
                $this->Flash->error(__('Ha ocurrido un error al crear el nuevo usuario. Por favor, inténtalo de nuevo.'));
            }
        } else {
            $usuario = $this->Usuario->newEntity();
        }

        $this->set(compact('usuario'));
    }
}
