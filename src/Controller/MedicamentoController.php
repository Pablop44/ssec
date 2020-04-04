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

    /*
    Variable que contiene los parametros del paginador
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

    /*
    Función que inicializa el controlador con las acciones accesibles
    */
    public function initialize()
    {
        parent::initialize();
        $this->Auth->allow(['delete','add', 'medicamentos', 'numeroMedicamentos']);
        $this->loadComponent('Csrf');
    }

    public function beforeFilter(Event $event) {
        $this->eventManager()->off($this->Csrf);
    }

    /*
    Devuelve una lista con los datos de la pagina especificada de todos los medicamentos
    */
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
                $conditions = array('nombre LIKE' => '%'.$data['filtro']['nombre'].'%', $marca, $minDosis, $maxDosis);
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

    /*
    Devuelve el número de medicamentos presentes en el sistema
    */
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

    /*
    Elimina un medicamento del sistema
    */
    public function delete()
    {
            $this->autoRender = false;
            $data = $this->request->getData();
            $medicamento = $this->Medicamento->find()->where(['nombre' => $data['nombre']])->all();
            foreach($medicamento as $medicamento){
                $nombre = $medicamento['nombre'];
            }
            $medicamentoAEliminar = $this->Medicamento->get($nombre);
            $this->Medicamento->delete($medicamentoAEliminar);
            $this->response->statusCode(200);
            $this->response->type('json');
            $json = json_encode($medicamentoAEliminar);
            $this->response->body($json);
    }

    /*
    Devuelve los datos de un medicamento
    */
    public function view($id = null)
    {
        $medicamento = $this->Medicamento->get($id, [
            'contain' => ['Tratamiento'],
        ]);

        $this->set('medicamento', $medicamento);
    }

    /*
    Añade un nuevo medicamento a sistema
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

    /*
    Edita los datos de un medicamento ya existente
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
}
