<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * TratamientoMedicamento Controller
 *
 * @property \App\Model\Table\TratamientoMedicamentoTable $TratamientoMedicamento
 *
 * @method \App\Model\Entity\TratamientoMedicamento[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class TratamientoMedicamentoController extends AppController
{
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
        $tratamientoMedicamento = $this->TratamientoMedicamento->newEntity();
        if ($this->request->is('post')) {
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
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $tratamientoMedicamento = $this->TratamientoMedicamento->get($id);
        if ($this->TratamientoMedicamento->delete($tratamientoMedicamento)) {
            $this->Flash->success(__('The tratamiento medicamento has been deleted.'));
        } else {
            $this->Flash->error(__('The tratamiento medicamento could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
