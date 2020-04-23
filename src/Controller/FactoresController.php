<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;
use Cake\Event\Event;
use Cake\I18n\FrozenTime;

/**
 * Factores Controller
 *
 * @property \App\Model\Table\FactoresTable $Factores
 *
 * @method \App\Model\Entity\Factore[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class FactoresController extends AppController
{

    public function initialize()
    {
        parent::initialize();
        $this->Auth->allow(['add']);
        $this->loadComponent('Csrf');
    }

    public function beforeFilter(Event $event) {
        
        $this->eventManager()->off($this->Csrf);   
    }
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function index()
    {
        $factores = $this->paginate($this->Factores);

        $this->set(compact('factores'));
    }

    /**
     * View method
     *
     * @param string|null $id Factore id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $factore = $this->Factores->get($id, [
            'contain' => [],
        ]);

        $this->set('factore', $factore);
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
        $factor = $this->Factores->newEntity();
        $factor = $this->Factores->patchEntity($factor, $data);
        if($this->Factores->save($factor)){
            $this->response->statusCode(200);
            $this->response->type('json');
            $json = json_encode($factor);
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
     * @param string|null $id Factore id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $factore = $this->Factores->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $factore = $this->Factores->patchEntity($factore, $this->request->getData());
            if ($this->Factores->save($factore)) {
                $this->Flash->success(__('The factore has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The factore could not be saved. Please, try again.'));
        }
        $this->set(compact('factore'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Factore id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $factore = $this->Factores->get($id);
        if ($this->Factores->delete($factore)) {
            $this->Flash->success(__('The factore has been deleted.'));
        } else {
            $this->Flash->error(__('The factore could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
