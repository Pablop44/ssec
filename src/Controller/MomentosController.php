<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;
use Cake\Event\Event;
use Cake\I18n\FrozenTime;

/**
 * Momentos Controller
 *
 * @property \App\Model\Table\MomentosTable $Momentos
 *
 * @method \App\Model\Entity\Momento[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class MomentosController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function initialize()
    {
        parent::initialize();
        $this->loadComponent('Csrf');
    }

    public function beforeFilter(Event $event) {
        
        $this->eventManager()->off($this->Csrf);   
    }

    public function index()
    {
        $momentos = $this->paginate($this->Momentos);

        $this->set(compact('momentos'));
    }

    /**
     * View method
     *
     * @param string|null $id Momento id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $momento = $this->Momentos->get($id, [
            'contain' => [],
        ]);

        $this->set('momento', $momento);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $this->autoRender = false;
        $data = $this->request->getData();
        $momento = $this->Momentos->newEntity();
        $momento = $this->Momentos->patchEntity($momento, $data);
        if($this->Momentos->save($momento)){
            $this->response->statusCode(200);
            $this->response->type('json');
            $json = json_encode($momento);
            $this->response->body($json);
        }else{
            header('Access-Control-Allow-Origin: *');
            $this->response->statusCode(500);
            header('Content-Type: application/json');
            $this->set('problema', 'Error al crear la consulta');    
            $this->set('_serialize', ['problema']); 
        } 
    }

    /**
     * Edit method
     *
     * @param string|null $id Momento id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $momento = $this->Momentos->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $momento = $this->Momentos->patchEntity($momento, $this->request->getData());
            if ($this->Momentos->save($momento)) {
                $this->Flash->success(__('The momento has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The momento could not be saved. Please, try again.'));
        }
        $this->set(compact('momento'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Momento id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $momento = $this->Momentos->get($id);
        if ($this->Momentos->delete($momento)) {
            $this->Flash->success(__('The momento has been deleted.'));
        } else {
            $this->Flash->error(__('The momento could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
