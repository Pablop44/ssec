<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;
use Cake\Event\Event;
use Cake\I18n\FrozenTime;

/**
 * Sintomas Controller
 *
 * @property \App\Model\Table\SintomasTable $Sintomas
 *
 * @method \App\Model\Entity\Sintoma[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class SintomasController extends AppController
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
        $sintomas = $this->paginate($this->Sintomas);

        $this->set(compact('sintomas'));
    }

    /**
     * View method
     *
     * @param string|null $id Sintoma id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $sintoma = $this->Sintomas->get($id, [
            'contain' => [],
        ]);

        $this->set('sintoma', $sintoma);
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
        $sintoma = $this->Sintomas->newEntity();
        $sintoma = $this->Sintomas->patchEntity($sintoma, $data);
        if($this->Sintomas->save($sintoma)){
            $this->response->statusCode(200);
            $this->response->type('json');
            $json = json_encode($sintoma);
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
     * @param string|null $id Sintoma id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $sintoma = $this->Sintomas->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $sintoma = $this->Sintomas->patchEntity($sintoma, $this->request->getData());
            if ($this->Sintomas->save($sintoma)) {
                $this->Flash->success(__('The sintoma has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The sintoma could not be saved. Please, try again.'));
        }
        $this->set(compact('sintoma'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Sintoma id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $sintoma = $this->Sintomas->get($id);
        if ($this->Sintomas->delete($sintoma)) {
            $this->Flash->success(__('The sintoma has been deleted.'));
        } else {
            $this->Flash->error(__('The sintoma could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
