<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Consulta Controller
 *
 * @property \App\Model\Table\ConsultaTable $Consulta
 *
 * @method \App\Model\Entity\Consultum[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ConsultaController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function index()
    {
        $consulta = $this->paginate($this->Consulta);

        $this->set(compact('consulta'));
    }

    /**
     * View method
     *
     * @param string|null $id Consultum id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $consultum = $this->Consulta->get($id, [
            'contain' => [],
        ]);

        $this->set('consultum', $consultum);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $consultum = $this->Consulta->newEntity();
        if ($this->request->is('post')) {
            $consultum = $this->Consulta->patchEntity($consultum, $this->request->getData());
            if ($this->Consulta->save($consultum)) {
                $this->Flash->success(__('The consultum has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The consultum could not be saved. Please, try again.'));
        }
        $this->set(compact('consultum'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Consultum id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $consultum = $this->Consulta->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $consultum = $this->Consulta->patchEntity($consultum, $this->request->getData());
            if ($this->Consulta->save($consultum)) {
                $this->Flash->success(__('The consultum has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The consultum could not be saved. Please, try again.'));
        }
        $this->set(compact('consultum'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Consultum id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $consultum = $this->Consulta->get($id);
        if ($this->Consulta->delete($consultum)) {
            $this->Flash->success(__('The consultum has been deleted.'));
        } else {
            $this->Flash->error(__('The consultum could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
