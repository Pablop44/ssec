<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Enfermedad Controller
 *
 * @property \App\Model\Table\EnfermedadTable $Enfermedad
 *
 * @method \App\Model\Entity\Enfermedad[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class EnfermedadController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function index()
    {
        $enfermedad = $this->paginate($this->Enfermedad);

        $this->set(compact('enfermedad'));
    }

    /**
     * View method
     *
     * @param string|null $id Enfermedad id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $enfermedad = $this->Enfermedad->get($id, [
            'contain' => ['Ficha'],
        ]);

        $this->set('enfermedad', $enfermedad);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $enfermedad = $this->Enfermedad->newEntity();
        if ($this->request->is('post')) {
            $enfermedad = $this->Enfermedad->patchEntity($enfermedad, $this->request->getData());
            if ($this->Enfermedad->save($enfermedad)) {
                $this->Flash->success(__('The enfermedad has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The enfermedad could not be saved. Please, try again.'));
        }
        $ficha = $this->Enfermedad->Ficha->find('list', ['limit' => 200]);
        $this->set(compact('enfermedad', 'ficha'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Enfermedad id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $enfermedad = $this->Enfermedad->get($id, [
            'contain' => ['Ficha'],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $enfermedad = $this->Enfermedad->patchEntity($enfermedad, $this->request->getData());
            if ($this->Enfermedad->save($enfermedad)) {
                $this->Flash->success(__('The enfermedad has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The enfermedad could not be saved. Please, try again.'));
        }
        $ficha = $this->Enfermedad->Ficha->find('list', ['limit' => 200]);
        $this->set(compact('enfermedad', 'ficha'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Enfermedad id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $enfermedad = $this->Enfermedad->get($id);
        if ($this->Enfermedad->delete($enfermedad)) {
            $this->Flash->success(__('The enfermedad has been deleted.'));
        } else {
            $this->Flash->error(__('The enfermedad could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
