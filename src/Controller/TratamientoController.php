<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Tratamiento Controller
 *
 * @property \App\Model\Table\TratamientoTable $Tratamiento
 *
 * @method \App\Model\Entity\Tratamiento[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class TratamientoController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function index()
    {
        $tratamiento = $this->paginate($this->Tratamiento);

        $this->set(compact('tratamiento'));
    }

    /**
     * View method
     *
     * @param string|null $id Tratamiento id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $tratamiento = $this->Tratamiento->get($id, [
            'contain' => ['Medicamento'],
        ]);

        $this->set('tratamiento', $tratamiento);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $tratamiento = $this->Tratamiento->newEntity();
        if ($this->request->is('post')) {
            $tratamiento = $this->Tratamiento->patchEntity($tratamiento, $this->request->getData());
            if ($this->Tratamiento->save($tratamiento)) {
                $this->Flash->success(__('The tratamiento has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The tratamiento could not be saved. Please, try again.'));
        }
        $medicamento = $this->Tratamiento->Medicamento->find('list', ['limit' => 200]);
        $this->set(compact('tratamiento', 'medicamento'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Tratamiento id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $tratamiento = $this->Tratamiento->get($id, [
            'contain' => ['Medicamento'],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $tratamiento = $this->Tratamiento->patchEntity($tratamiento, $this->request->getData());
            if ($this->Tratamiento->save($tratamiento)) {
                $this->Flash->success(__('The tratamiento has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The tratamiento could not be saved. Please, try again.'));
        }
        $medicamento = $this->Tratamiento->Medicamento->find('list', ['limit' => 200]);
        $this->set(compact('tratamiento', 'medicamento'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Tratamiento id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $tratamiento = $this->Tratamiento->get($id);
        if ($this->Tratamiento->delete($tratamiento)) {
            $this->Flash->success(__('The tratamiento has been deleted.'));
        } else {
            $this->Flash->error(__('The tratamiento could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
