<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;
use Cake\Event\Event;
use Cake\I18n\FrozenTime;

/**
 * TratamientoMedicamento Controller
 *
 * @property \App\Model\Table\TratamientoMedicamentoTable $TratamientoMedicamento
 *
 * @method \App\Model\Entity\TratamientoMedicamento[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class TratamientoMedicamentoController extends AppController
{

    public function initialize()
    {
        parent::initialize();
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
        $tratamientoMedicamento = $this->paginate($this->TratamientoMedicamento);

        $this->set(compact('tratamientoMedicamento'));
    }

    /**
     * View method
     *
     * @param string|null $id Tratamiento Medicamento id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $tratamientoMedicamento = $this->TratamientoMedicamento->get($id, [
            'contain' => [],
        ]);

        $this->set('tratamientoMedicamento', $tratamientoMedicamento);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $this->autoRender = false;
        $tratamientoMedicamento = $this->TratamientoMedicamento->newEntity();
        $tratamientoMedicamento = $this->TratamientoMedicamento->patchEntity($tratamientoMedicamento, $this->request->getData());
        $this->TratamientoMedicamento->save($tratamientoMedicamento);
        $this->response->statusCode(200);
        $this->response->type('json');
        $json = json_encode($tratamientoMedicamento);
        $this->response->body($json);
    }

    /**
     * Edit method
     *
     * @param string|null $id Tratamiento Medicamento id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $tratamientoMedicamento = $this->TratamientoMedicamento->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $tratamientoMedicamento = $this->TratamientoMedicamento->patchEntity($tratamientoMedicamento, $this->request->getData());
            if ($this->TratamientoMedicamento->save($tratamientoMedicamento)) {
                $this->Flash->success(__('The tratamiento medicamento has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The tratamiento medicamento could not be saved. Please, try again.'));
        }
        $this->set(compact('tratamientoMedicamento'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Tratamiento Medicamento id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete()
    {
        $this->autoRender = false;
        $data = $this->request->getData();
        $tratamientoMedicamento = $this->TratamientoMedicamento->get([$data['medicamento'], $data['tratamiento']]);
        if ($this->TratamientoMedicamento->delete($tratamientoMedicamento)){
            $this->response->statusCode(200);
            $this->response->type('json');
            $json = json_encode($tratamientoMedicamento);
            $this->response->body($json);
        } else {
            $this->response->statusCode(500);
            $this->response->type('json');
            $json = json_encode($tratamientoMedicamento);
            $this->response->body($json);
        }
    }
}
