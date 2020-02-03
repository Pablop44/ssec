<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Consejo Controller
 *
 * @property \App\Model\Table\ConsejoTable $Consejo
 *
 * @method \App\Model\Entity\Consejo[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ConsejoController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function index()
    {
        $consejo = $this->paginate($this->Consejo);

        $this->set(compact('consejo'));
    }

    /**
     * View method
     *
     * @param string|null $id Consejo id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $consejo = $this->Consejo->get($id, [
            'contain' => [],
        ]);

        $this->set('consejo', $consejo);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $consejo = $this->Consejo->newEntity();
        if ($this->request->is('post')) {
            $consejo = $this->Consejo->patchEntity($consejo, $this->request->getData());
            if ($this->Consejo->save($consejo)) {
                $this->Flash->success(__('The consejo has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The consejo could not be saved. Please, try again.'));
        }
        $this->set(compact('consejo'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Consejo id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $consejo = $this->Consejo->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $consejo = $this->Consejo->patchEntity($consejo, $this->request->getData());
            if ($this->Consejo->save($consejo)) {
                $this->Flash->success(__('The consejo has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The consejo could not be saved. Please, try again.'));
        }
        $this->set(compact('consejo'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Consejo id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $consejo = $this->Consejo->get($id);
        if ($this->Consejo->delete($consejo)) {
            $this->Flash->success(__('The consejo has been deleted.'));
        } else {
            $this->Flash->error(__('The consejo could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
