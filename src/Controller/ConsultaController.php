<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;
use Cake\I18n\FrozenTime;

/**
 * Consulta Controller
 *
 * @property \App\Model\Table\ConsultaTable $Consulta
 *
 * @method \App\Model\Entity\Consultum[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ConsultaController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */

    public function initialize()
    {
        parent::initialize();
        $this->Auth->allow(['consultas', 'consultaFicha', 'getHoras']);
        $this->loadComponent('Csrf');
    }

    public function consultas()
    {
        $this->autoRender = false;
        $consultas = $this->Consulta->find()->all();

        foreach($consultas as $consulta){
            $user = TableRegistry::getTableLocator()->get('User');
            $iteradorUsuario = $user->find()->where(['id' => $consulta['medico']])->all();
            $iteradorUsuario2 = $user->find()->where(['id' => $consulta['paciente']])->all();
            foreach($iteradorUsuario as $usuario){
                $consulta['medico'] = $usuario['nombre'].' '.$usuario['apellidos'];
                $consulta['colegiado'] = $usuario['colegiado'];
            }
            foreach($iteradorUsuario2 as $usuario2){
                $consulta['paciente'] = $usuario2['nombre'].' '.$usuario2['apellidos'];
                $consulta['dniPaciente'] = $usuario2['dni'];
            }
        }

        $this->response->statusCode(200);
        $this->response->type('json');
        $json = json_encode($consultas);
        $this->response->body($json);
    }

    /**
     * View method
     *
     * @param string|null $id Consultum id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $consultum = $this->Consulta->get($id, [
            'contain' => [],
        ]);

        $this->set('consultum', $consultum);
    }

    public function consultaFicha($id = null)
    {
        $this->autoRender = false;
        $consultas = $this->Consulta->find()->where(['ficha' => $id])->all();

        foreach($consultas as $consulta){
            $fecha = FrozenTime::parse($consulta['fecha']);
            $consulta->fecha = $fecha;
            
            $consulta->fecha =  $consulta->fecha->i18nFormat('dd/MM/YYYY HH:mm:ss');

        }
        
    
        $this->response->statusCode(200);
        $this->response->type('json');
        $json = json_encode($consultas);
        $this->response->body($json);
    }

    public function getHoras($fecha = null)
    {
        $this->autoRender = false;
        $consultas = $this->Consulta->find()->where(['fecha LIKE' => '%'.$fecha.'%'])->all();
        $horas = array();
        $horas['9'] = false;
        $horas['10'] = false;
        $horas['11'] = false;
        $horas['12'] = false;
        $horas['13'] = false;
        $horas['14'] = false;
        $horas['15'] = false;
        $horas['16'] = false;
        foreach($consultas as $consulta){
            $fecha = FrozenTime::parse($consulta['fecha']);
            $consulta->fecha = $fecha;
            
            $consulta->fecha =  $consulta->fecha->i18nFormat('dd/MM/YYYY HH:mm:ss');
           if(strpos($consulta->fecha, '09:00:00')){
            $horas['9'] = true;
           }
           if(strpos($consulta->fecha, '10:00:00')){
            $horas['10'] = true;
           }
           if(strpos($consulta->fecha, '11:00:00')){
            $horas['11'] = true;
           }
           if(strpos($consulta->fecha, '12:00:00')){
            $horas['12'] = true;
           }
           if(strpos($consulta->fecha, '13:00:00')){
            $horas['13'] = true;
           }
           if(strpos($consulta->fecha, '14:00:00')){
            $horas['14'] = true;
           }
           if(strpos($consulta->fecha, '15:00:00')){
            $horas['15'] = true;
           }
           if(strpos($consulta->fecha, '16:00:00')){
            $horas['16'] = true;
           }

        } 
    
        $this->response->statusCode(200);
        $this->response->type('json');
        $json = json_encode($horas);
        $this->response->body($json);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $consultum = $this->Consulta->newEntity();
        if ($this->request->is('post')) {
            $consultum = $this->Consulta->patchEntity($consultum, $this->request->getData());
            if ($this->Consulta->save($consultum)) {
                $this->Flash->success(__('The consultum has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The consultum could not be saved. Please, try again.'));
        }
        $this->set(compact('consultum'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Consultum id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $consultum = $this->Consulta->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $consultum = $this->Consulta->patchEntity($consultum, $this->request->getData());
            if ($this->Consulta->save($consultum)) {
                $this->Flash->success(__('The consultum has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The consultum could not be saved. Please, try again.'));
        }
        $this->set(compact('consultum'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Consultum id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $consultum = $this->Consulta->get($id);
        if ($this->Consulta->delete($consultum)) {
            $this->Flash->success(__('The consultum has been deleted.'));
        } else {
            $this->Flash->error(__('The consultum could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
