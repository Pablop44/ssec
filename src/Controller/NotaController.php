<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Nota Controller
 *
 * @property \App\Model\Table\NotaTable $Nota
 *
 * @method \App\Model\Entity\Notum[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class NotaController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function index()
    {
        $nota = $this->paginate($this->Nota);

        $this->set(compact('nota'));
    }

    /**
     * View method
     *
     * @param string|null $id Notum id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $notum = $this->Nota->get($id, [
            'contain' => [],
        ]);

        $this->set('notum', $notum);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $notum = $this->Nota->newEntity();
        if ($this->request->is('post')) {
            $notum = $this->Nota->patchEntity($notum, $this->request->getData());
            if ($this->Nota->save($notum)) {
                $this->Flash->success(__('The notum has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The notum could not be saved. Please, try again.'));
        }
        $this->set(compact('notum'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Notum id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $notum = $this->Nota->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $notum = $this->Nota->patchEntity($notum, $this->request->getData());
            if ($this->Nota->save($notum)) {
                $this->Flash->success(__('The notum has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The notum could not be saved. Please, try again.'));
        }
        $this->set(compact('notum'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Notum id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $notum = $this->Nota->get($id);
        if ($this->Nota->delete($notum)) {
            $this->Flash->success(__('The notum has been deleted.'));
        } else {
            $this->Flash->error(__('The notum could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
