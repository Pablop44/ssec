<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;

/**
 * Cuenta Controller
 *
 * @property \App\Model\Table\CuentaTable $Cuenta
 *
 * @method \App\Model\Entity\Cuentum[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class CuentaController extends AppController
{
    public function initialize()
    {
        parent::initialize();
        $this->loadComponent('Csrf');
    }

    public function beforeFilter(Event $event) {
        $this->eventManager()->off($this->Csrf);
    }

    /*
    Añadir una cuenta al sistema
    */
    public function add($datos)
    {
        $cuentum = $this->Cuenta->newEntity();
        $cuentum = $this->Cuenta->patchEntity($cuentum, $datos);
        $this->Cuenta->save($cuentum);
    }

    /*
    Editar una cuenta con un estado
    */
    public function edit($id = null, $valorCuenta = null)
    {
        $cuentum = $this->Cuenta->get($id, [
            'contain' => [],
        ]);
        $cuentum['estado'] = $valorCuenta;
        $cuentum = $this->Cuenta->patchEntity($cuentum, $this->request->getData());
        $this->Cuenta->save($cuentum);
    }

    /*
    Editar una cuenta con un estado desactivado
    */
    public function edit2($id = null)
    {
        $cuentum = $this->Cuenta->get($id, [
            'contain' => [],
        ]);
        $cuentum['estado'] = "activada";
        $cuentum = $this->Cuenta->patchEntity($cuentum, $this->request->getData());
        $this->Cuenta->save($cuentum);
    }

    /*
    Editar una cuenta con un autorizado
    */
    public function edit3($id = null)
    {
        $cuentum = $this->Cuenta->get($id, [
            'contain' => [],
        ]);
        $cuentum['estado'] = "autorizada";
        $cuentum = $this->Cuenta->patchEntity($cuentum, $this->request->getData());
        $this->Cuenta->save($cuentum);
    }

    /*
    Editar una cuenta con un desactivado
    */
    public function desactivar($user = null)
    {
        $this->autoRender = false;
        $cuentas = $this->Cuenta->find()->where(['user' => $user])->all();
        foreach($cuentas as $cuenta){
            $cuenta = $cuenta;
        }
        $cuentum['estado'] = "desactivada";
        $cuentum = $this->Cuenta->patchEntity($cuenta , $cuentum);
        if($this->Cuenta->save($cuentum)){
            $this->response->statusCode(200);
            $this->response->type('json');
            $json = json_encode($cuentum);
            $this->response->body($json);
        }else{
            $this->response->statusCode(500);
            $this->response->type('json');
            $json = json_encode($cuentum->errors());
            $this->response->body($json);
        } 
    }


    /*
    Eliminar una cuenta
    */
    public function delete($id = null)
    {
        $cuentum = $this->Cuenta->get($id);
        $this->Cuenta->delete($cuentum);
    }
}