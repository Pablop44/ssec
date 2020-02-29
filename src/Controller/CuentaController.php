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
    public function add($datos)
    {
        $cuentum = $this->Cuenta->newEntity();
            $cuentum = $this->Cuenta->patchEntity($cuentum, $datos);
           $this->Cuenta->save($cuentum);
    }

    /**
     * Edit method
     *
     * @param string|null $id Cuentum id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null, $datos)
    {
        $this->autoRender = false;
        $cuentum = $this->Cuenta->get($id, [
            'contain' => [],
        ]);
            $cuentum = $this->Cuenta->patchEntity($cuentum, $datos);
            if (!$this->Cuenta->save($cuentum)) {
                $this->response->statusCode(500);
                $this->response->type('json');
                $this->set('respuesta', 'No se ha actualizado la cuenta');   
                $this->set('_serialize', ['respuesta']);
            }   
    }
        
    

    public function edit2($id = null)
    {
        $cuentum = $this->Cuenta->get($id, [
            'contain' => [],
        ]);
        $cuentum['estado'] = "activada";
            $cuentum = $this->Cuenta->patchEntity($cuentum, $this->request->getData());
            $this->Cuenta->save($cuentum);
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
        $cuentum = $this->Cuenta->get($id);
        $this->Cuenta->delete($cuentum);
    }
}
