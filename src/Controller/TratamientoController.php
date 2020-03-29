<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;
use Cake\Event\Event;
use Cake\I18n\FrozenTime;

/**
 * Tratamiento Controller
 *
 * @property \App\Model\Table\TratamientoTable $Tratamiento
 *
 * @method \App\Model\Entity\Tratamiento[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class TratamientoController extends AppController
{
    public $paginate = [
        'page' => 1,
        'limit' => 10,
        'maxLimit' => 15,
        'fields' => [
            'id', 'posologia', 'fechaInicio', 'fechaFin', 'horario', 'enfermedad'
        ],
        'sortWhitelist' => [
            'id', 'posologia', 'fechaInicio', 'fechaFin', 'horario', 'enfermedad'
        ]
    ];

    public function initialize()
    {
        parent::initialize();
        $this->Auth->allow(['tratramientosFicha', 'numeroTratramientosFicha', 'view']);
        $this->loadComponent('Csrf');
        $this->loadComponent('Paginator');
    }

    public function beforeFilter(Event $event) {
        
        $this->eventManager()->off($this->Csrf);
    
    }


    public function tratramientosFicha()
    {
        $this->autoRender = false;
        $data = $this->request->getData();

        $this->paginate['page'] = $data['page']+1;
        $this->paginate['limit'] = $data['limit'];

        if(isset($data['tipo'])){
            $this->paginate['order'] = [$data['tipo'] => 'desc'];
        }

        $conditions = array('ficha' => $data['idFicha']);
    

        $tratamiento = $this->Tratamiento->find('all', array('conditions' => $conditions));
        $paginador = $this->paginate($tratamiento);

        foreach($paginador as $tratamiento){
            $fecha = FrozenTime::parse($tratamiento['fechaInicio']);
            $tratamiento->fechaInicio = $fecha;
            $tratamiento->fechaInicio =  $tratamiento->fechaInicio->i18nFormat('dd/MM/YYYY HH:mm:ss');

            $fecha2 = FrozenTime::parse($tratamiento['fechaFin']);
            $tratamiento->fechaFin = $fecha2;
            $tratamiento->fechaFin =  $tratamiento->fechaFin->i18nFormat('dd/MM/YYYY HH:mm:ss');

            $horario = FrozenTime::parse($tratamiento['horario']);
            $tratamiento->horario = $horario;
            $tratamiento->horario =  $tratamiento->horario->i18nFormat('HH:mm');

            $tratamientoMedicamento = TableRegistry::getTableLocator()->get('TratamientoMedicamento');
            $iteradorMedicamentos = $tratamientoMedicamento->find()->where(['tratamiento' => $tratamiento['id']])->all();

            foreach($iteradorMedicamentos as $tratamientoMedicamento1){
                $medicamentos = TableRegistry::getTableLocator()->get('Medicamento');
                $iteradorMedicamentos2 = $medicamentos->find()->where(['nombre' => $tratamientoMedicamento1['medicamento']])->all();
                $tratamiento['medicamentos'] = $iteradorMedicamentos2;
            }
        }

        $this->response->statusCode(200);
        $this->response->type('json');
        $json = json_encode($paginador);
        $this->response->body($json);
    }

    public function numeroTratramientosFicha()
    {
        $this->autoRender = false;
        $data = $this->request->getData();

        $conditions = array('ficha' => $data['idFicha']);
    

        $tratamiento = $this->Tratamiento->find('all', array('conditions' => $conditions));
        $paginador = $this->paginate($tratamiento);

        $i = 0;

        foreach($paginador as $tratamiento){
            $i++;
        }

        $obj = array();
        $obj['numero'] = $i;

        $this->response->statusCode(200);
        $this->response->type('json');
        $json = json_encode($obj);
        $this->response->body($json);
    }

    /**
     * View method
     *
     * @param string|null $id Tratamiento id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $this->autoRender = false;
        $tratamiento = $this->Tratamiento->get($id);

        $tratamientoMedicamento = TableRegistry::getTableLocator()->get('TratamientoMedicamento');
        $iteradorMedicamentos = $tratamientoMedicamento->find()->where(['tratamiento' => $tratamiento['id']])->all();

        foreach($iteradorMedicamentos as $tratamientoMedicamento1){
            $medicamentos = TableRegistry::getTableLocator()->get('Medicamento');
            $iteradorMedicamentos2 = $medicamentos->find()->where(['nombre' => $tratamientoMedicamento1['medicamento']])->all();
            $tratamiento['medicamentos'] = $iteradorMedicamentos2;
        }

        $fecha = FrozenTime::parse($tratamiento['fechaInicio']);
        $tratamiento->fechaInicio = $fecha;
        $tratamiento->fechaInicio =  $tratamiento->fechaInicio->i18nFormat('dd/MM/YYYY HH:mm:ss');

        $fecha2 = FrozenTime::parse($tratamiento['fechaFin']);
        $tratamiento->fechaFin = $fecha2;
        $tratamiento->fechaFin =  $tratamiento->fechaFin->i18nFormat('dd/MM/YYYY HH:mm:ss');

        $horario = FrozenTime::parse($tratamiento['horario']);
        $tratamiento->horario = $horario;
        $tratamiento->horario =  $tratamiento->horario->i18nFormat('HH:mm');

        $this->response->statusCode(200);
        $this->response->type('json');
        $json = json_encode($tratamiento);
        $this->response->body($json);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $tratamiento = $this->Tratamiento->newEntity();
        if ($this->request->is('post')) {
            $tratamiento = $this->Tratamiento->patchEntity($tratamiento, $this->request->getData());
            if ($this->Tratamiento->save($tratamiento)) {
                $this->Flash->success(__('The tratamiento has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The tratamiento could not be saved. Please, try again.'));
        }
        $medicamento = $this->Tratamiento->Medicamento->find('list', ['limit' => 200]);
        $this->set(compact('tratamiento', 'medicamento'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Tratamiento id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $tratamiento = $this->Tratamiento->get($id, [
            'contain' => ['Medicamento'],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $tratamiento = $this->Tratamiento->patchEntity($tratamiento, $this->request->getData());
            if ($this->Tratamiento->save($tratamiento)) {
                $this->Flash->success(__('The tratamiento has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The tratamiento could not be saved. Please, try again.'));
        }
        $medicamento = $this->Tratamiento->Medicamento->find('list', ['limit' => 200]);
        $this->set(compact('tratamiento', 'medicamento'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Tratamiento id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $tratamiento = $this->Tratamiento->get($id);
        if ($this->Tratamiento->delete($tratamiento)) {
            $this->Flash->success(__('The tratamiento has been deleted.'));
        } else {
            $this->Flash->error(__('The tratamiento could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
