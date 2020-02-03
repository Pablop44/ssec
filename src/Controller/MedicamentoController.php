<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Medicamento Controller
 *
 * @property \App\Model\Table\MedicamentoTable $Medicamento
 *
 * @method \App\Model\Entity\Medicamento[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class MedicamentoController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function index()
    {
        $medicamento = $this->paginate($this->Medicamento);

        $this->set(compact('medicamento'));
    }

    /**
     * View method
     *
     * @param string|null $id Medicamento id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $medicamento = $this->Medicamento->get($id, [
            'contain' => ['Tratamiento'],
        ]);

        $this->set('medicamento', $medicamento);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $medicamento = $this->Medicamento->newEntity();
        if ($this->request->is('post')) {
            $medicamento = $this->Medicamento->patchEntity($medicamento, $this->request->getData());
            if ($this->Medicamento->save($medicamento)) {
                $this->Flash->success(__('The medicamento has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The medicamento could not be saved. Please, try again.'));
        }
        $tratamiento = $this->Medicamento->Tratamiento->find('list', ['limit' => 200]);
        $this->set(compact('medicamento', 'tratamiento'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Medicamento id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $medicamento = $this->Medicamento->get($id, [
            'contain' => ['Tratamiento'],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $medicamento = $this->Medicamento->patchEntity($medicamento, $this->request->getData());
            if ($this->Medicamento->save($medicamento)) {
                $this->Flash->success(__('The medicamento has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The medicamento could not be saved. Please, try again.'));
        }
        $tratamiento = $this->Medicamento->Tratamiento->find('list', ['limit' => 200]);
        $this->set(compact('medicamento', 'tratamiento'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Medicamento id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $medicamento = $this->Medicamento->get($id);
        if ($this->Medicamento->delete($medicamento)) {
            $this->Flash->success(__('The medicamento has been deleted.'));
        } else {
            $this->Flash->error(__('The medicamento could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
