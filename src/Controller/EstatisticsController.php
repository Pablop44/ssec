<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;
use Cake\I18n\FrozenTime;
use Cake\Event\Event;
use Cake\I18n\Time;

/**
 * Estatistics Controller
 *
 *
 * @method \App\Model\Entity\Estatistic[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class EstatisticsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */

    public function initialize()
    {
        parent::initialize();
        $this->loadComponent('Csrf');
        $this->loadComponent('Paginator');
    }

    public function beforeFilter(Event $event) {
        
        $this->eventManager()->off($this->Csrf);
    
    }


    public function estadisticasUsuario()
    {
        $this->autoRender = false;
        $cuentas = TableRegistry::getTableLocator()->get('Cuenta');
        $iteradorUsuarioMedicos = $cuentas->find()->where(['rol' => 'medico'])->all();
        $iteradorUsuarioPacientes = $cuentas->find()->where(['rol' => 'paciente'])->all();
        $iteradorUsuarioAdministradores = $cuentas->find()->where(['rol' => 'administrador'])->all();

        $array = array();
        $array['medicos'] = sizeof($iteradorUsuarioMedicos);
        $array['administradores'] = sizeof($iteradorUsuarioAdministradores);
        $array['pacientes'] = sizeof($iteradorUsuarioPacientes);

        $this->response->statusCode(200);
        $this->response->type('json');
        $json = json_encode($array);
        $this->response->body($json);
    }


    public function estadisticasEnfermedades()
    {
        $this->autoRender = false;
        $enfermedades = TableRegistry::getTableLocator()->get('FichaEnfermedad');
        $iteradorEnfermedadAsma = $enfermedades->find()->where(['enfermedad' => 'asma'])->all();
        $iteradorEnfermedadMigranas = $enfermedades->find()->where(['enfermedad' => 'migranas'])->all();
        $iteradorEnfermedadDiabetes = $enfermedades->find()->where(['enfermedad' => 'diabetes'])->all();

        $array = array();
        $array['asma'] = sizeof($iteradorEnfermedadAsma);
        $array['migranas'] = sizeof($iteradorEnfermedadMigranas);
        $array['diabetes'] = sizeof($iteradorEnfermedadDiabetes);

        $this->response->statusCode(200);
        $this->response->type('json');
        $json = json_encode($array);
        $this->response->body($json);
    }



    /**
     * View method
     *
     * @param string|null $id Estatistic id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $estatistic = $this->Estatistics->get($id, [
            'contain' => [],
        ]);

        $this->set('estatistic', $estatistic);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $estatistic = $this->Estatistics->newEntity();
        if ($this->request->is('post')) {
            $estatistic = $this->Estatistics->patchEntity($estatistic, $this->request->getData());
            if ($this->Estatistics->save($estatistic)) {
                $this->Flash->success(__('The estatistic has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The estatistic could not be saved. Please, try again.'));
        }
        $this->set(compact('estatistic'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Estatistic id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $estatistic = $this->Estatistics->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $estatistic = $this->Estatistics->patchEntity($estatistic, $this->request->getData());
            if ($this->Estatistics->save($estatistic)) {
                $this->Flash->success(__('The estatistic has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The estatistic could not be saved. Please, try again.'));
        }
        $this->set(compact('estatistic'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Estatistic id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $estatistic = $this->Estatistics->get($id);
        if ($this->Estatistics->delete($estatistic)) {
            $this->Flash->success(__('The estatistic has been deleted.'));
        } else {
            $this->Flash->error(__('The estatistic could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
