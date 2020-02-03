<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Informe Controller
 *
 * @property \App\Model\Table\InformeTable $Informe
 *
 * @method \App\Model\Entity\Informe[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class InformeController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function index()
    {
        $informe = $this->paginate($this->Informe);

        $this->set(compact('informe'));
    }

    /**
     * View method
     *
     * @param string|null $id Informe id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $informe = $this->Informe->get($id, [
            'contain' => [],
        ]);

        $this->set('informe', $informe);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $informe = $this->Informe->newEntity();
        if ($this->request->is('post')) {
            $informe = $this->Informe->patchEntity($informe, $this->request->getData());
            if ($this->Informe->save($informe)) {
                $this->Flash->success(__('The informe has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The informe could not be saved. Please, try again.'));
        }
        $this->set(compact('informe'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Informe id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $informe = $this->Informe->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $informe = $this->Informe->patchEntity($informe, $this->request->getData());
            if ($this->Informe->save($informe)) {
                $this->Flash->success(__('The informe has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The informe could not be saved. Please, try again.'));
        }
        $this->set(compact('informe'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Informe id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $informe = $this->Informe->get($id);
        if ($this->Informe->delete($informe)) {
            $this->Flash->success(__('The informe has been deleted.'));
        } else {
            $this->Flash->error(__('The informe could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
