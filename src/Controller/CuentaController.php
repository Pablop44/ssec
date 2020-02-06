<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Cuenta Controller
 *
 * @property \App\Model\Table\CuentaTable $Cuenta
 *
 * @method \App\Model\Entity\Cuentum[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class CuentaController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function index()
    {
        $cuenta = $this->paginate($this->Cuenta);

        $this->set(compact('cuenta'));
    }

    /**
     * View method
     *
     * @param string|null $id Cuentum id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $cuentum = $this->Cuenta->get($id, [
            'contain' => [],
        ]);

        $this->set('cuentum', $cuentum);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $cuentum = $this->Cuenta->newEntity();
        $cuentum = $this->Cuenta->patchEntity($cuentum, $this->request->getData());
        $this->Cuenta->save($cuentum);
    }

    /**
     * Edit method
     *
     * @param string|null $id Cuentum id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $cuentum = $this->Cuenta->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $cuentum = $this->Cuenta->patchEntity($cuentum, $this->request->getData());
            if ($this->Cuenta->save($cuentum)) {
                $this->Flash->success(__('The cuentum has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The cuentum could not be saved. Please, try again.'));
        }
        $this->set(compact('cuentum'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Cuentum id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $cuentum = $this->Cuenta->get($id);
        if ($this->Cuenta->delete($cuentum)) {
            $this->Flash->success(__('The cuentum has been deleted.'));
        } else {
            $this->Flash->error(__('The cuentum could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
