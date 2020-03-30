<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Factores Controller
 *
 * @property \App\Model\Table\FactoresTable $Factores
 *
 * @method \App\Model\Entity\Factore[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class FactoresController extends AppController
{
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
        $factore = $this->Factores->newEntity();
        if ($this->request->is('post')) {
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
