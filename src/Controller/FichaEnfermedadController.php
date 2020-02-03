<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * FichaEnfermedad Controller
 *
 * @property \App\Model\Table\FichaEnfermedadTable $FichaEnfermedad
 *
 * @method \App\Model\Entity\FichaEnfermedad[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class FichaEnfermedadController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function index()
    {
        $fichaEnfermedad = $this->paginate($this->FichaEnfermedad);

        $this->set(compact('fichaEnfermedad'));
    }

    /**
     * View method
     *
     * @param string|null $id Ficha Enfermedad id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $fichaEnfermedad = $this->FichaEnfermedad->get($id, [
            'contain' => [],
        ]);

        $this->set('fichaEnfermedad', $fichaEnfermedad);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $fichaEnfermedad = $this->FichaEnfermedad->newEntity();
        if ($this->request->is('post')) {
            $fichaEnfermedad = $this->FichaEnfermedad->patchEntity($fichaEnfermedad, $this->request->getData());
            if ($this->FichaEnfermedad->save($fichaEnfermedad)) {
                $this->Flash->success(__('The ficha enfermedad has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The ficha enfermedad could not be saved. Please, try again.'));
        }
        $this->set(compact('fichaEnfermedad'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Ficha Enfermedad id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $fichaEnfermedad = $this->FichaEnfermedad->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $fichaEnfermedad = $this->FichaEnfermedad->patchEntity($fichaEnfermedad, $this->request->getData());
            if ($this->FichaEnfermedad->save($fichaEnfermedad)) {
                $this->Flash->success(__('The ficha enfermedad has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The ficha enfermedad could not be saved. Please, try again.'));
        }
        $this->set(compact('fichaEnfermedad'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Ficha Enfermedad id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $fichaEnfermedad = $this->FichaEnfermedad->get($id);
        if ($this->FichaEnfermedad->delete($fichaEnfermedad)) {
            $this->Flash->success(__('The ficha enfermedad has been deleted.'));
        } else {
            $this->Flash->error(__('The ficha enfermedad could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
