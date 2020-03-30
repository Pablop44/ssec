<?php
namespace App\Controller;

use App\Controller\AppController;

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
        $sintoma = $this->Sintomas->newEntity();
        if ($this->request->is('post')) {
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
