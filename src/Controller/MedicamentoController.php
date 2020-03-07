<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;

/**
 * Medicamento Controller
 *
 * @property \App\Model\Table\MedicamentoTable $Medicamento
 *
 * @method \App\Model\Entity\Medicamento[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class MedicamentoController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public $paginate = [
        'page' => 1,
        'limit' => 10,
        'maxLimit' => 15,
        'fields' => [
            'nombre', 'viaAdministracion', 'marca', 'dosis'
        ],
        'sortWhitelist' => [
            'nombre', 'viaAdministracion', 'marca', 'dosis'
        ]
    ];

    public function initialize()
    {
        parent::initialize();
        $this->Auth->allow(['delete','add', 'medicamentos', 'numeroMedicamentos']);
        $this->loadComponent('Csrf');
    }

    public function beforeFilter(Event $event) {
        
            $this->eventManager()->off($this->Csrf);
        
    }

    public function medicamentos()
    {
        $this->autoRender = false;
        $data = $this->request->getData();
        $this->paginate['page'] = $data['page']+1;
        $this->paginate['limit'] = $data['limit'];
        if(isset($data['tipo'])){
            $this->paginate['order'] = [$data['tipo'] => 'desc'];
        }
        if(!isset($data['filtro'])){
            $conditions = array();
        }else{
            
            if(isset($data['filtro']['minDosis'])){
                $minDosis =  array('dosis >' => $data['filtro']['minDosis']);
            }else{
                $minDosis = "";
            }
            if(isset($data['filtro']['maxDosis'])){
                $maxDosis =  array('dosis <' => $data['filtro']['maxDosis']);
            }else{
                $maxDosis = "";
            }
            if(isset($data['filtro']['marca'])){
                $marca =  array('marca' => $data['filtro']['marca']);
            }else{
                $marca = "";
            }
            
            if(isset($data['filtro']['nombre'])){
                $conditions = array('nombre' => $data['filtro']['nombre'], $marca, $minDosis, $maxDosis);
            }else{
                $conditions = array($marca, $minDosis, $maxDosis);
            }  
        }  
        
        $medicamentos = $this->Medicamento->find('all', array('conditions' => $conditions));
        $paginador = $this->paginate($medicamentos);

        $this->response->statusCode(200);
        $this->response->type('json');
        $json = json_encode($paginador);
        $this->response->body($json);
    }

    public function numeroMedicamentos()
    {
        $this->autoRender = false;
        $data = $this->request->getData();
        if(!isset($data['filtro'])){
            $conditions = array();
        }else{
            
            if(isset($data['filtro']['minDosis'])){
                $minDosis =  array('dosis >' => $data['filtro']['minDosis']);
            }else{
                $minDosis = "";
            }
            if(isset($data['filtro']['maxDosis'])){
                $maxDosis =  array('dosis <' => $data['filtro']['maxDosis']);
            }else{
                $maxDosis = "";
            }
            if(isset($data['filtro']['marca'])){
                $marca =  array('marca' => $data['filtro']['marca']);
            }else{
                $marca = "";
            }
            
            if(isset($data['filtro']['nombre'])){
                $conditions = array('nombre' => $data['filtro']['nombre'], $marca, $minDosis, $maxDosis);
            }else{
                $conditions = array($marca, $minDosis, $maxDosis);
            }  
        }  
        $medicamentos = $this->Medicamento->find('all', array('conditions' => $conditions));
        $i = 0;
        foreach($medicamentos as $medicamento){
            $i++;
        }

        $myobj = array();
        $myobj['numero'] = $i;

        $this->response->statusCode(200);
        $this->response->type('json');
        $json = json_encode($myobj);
        $this->response->body($json);
    }

    public function delete($nombre = null)
    {

        $this->Medicamento->deleteAll(['nombre' => $nombre]);
            $this->response->statusCode(200);
            $this->response->type('json');
            $this->set('respuesta', 'Se ha eliminado correctamente');   
            $this->set('_serialize', ['respuesta']);
            $this->set('_serialize', ['respuesta']);
    }

    /**
     * View method
     *
     * @param string|null $id Medicamento id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $medicamento = $this->Medicamento->get($id, [
            'contain' => ['Tratamiento'],
        ]);

        $this->set('medicamento', $medicamento);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        
        $this->autoRender = false;
        $medicamento = $this->Medicamento->newEntity();
        $medicamento = $this->Medicamento->patchEntity($medicamento, $this->request->getData());
        $this->Medicamento->save($medicamento);

        $this->response->statusCode(200);
        $this->response->type('json');
        $json = json_encode($medicamento);
        $this->response->body($json);
    }

    /**
     * Edit method
     *
     * @param string|null $id Medicamento id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $medicamento = $this->Medicamento->get($id, [
            'contain' => ['Tratamiento'],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $medicamento = $this->Medicamento->patchEntity($medicamento, $this->request->getData());
            if ($this->Medicamento->save($medicamento)) {
                $this->Flash->success(__('The medicamento has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The medicamento could not be saved. Please, try again.'));
        }
        $tratamiento = $this->Medicamento->Tratamiento->find('list', ['limit' => 200]);
        $this->set(compact('medicamento', 'tratamiento'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Medicamento id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    
}
