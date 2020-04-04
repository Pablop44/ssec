<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;
use Cake\Event\Event;
use Cake\I18n\FrozenTime;
/**
 * Ficha Controller
 *
 * @property \App\Model\Table\FichaTable $Ficha
 *
 * @method \App\Model\Entity\Ficha[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class FichaController extends AppController
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
            'id', 'fechaCreacion', 'paciente', 'medico'
        ],
        'sortWhitelist' => [
            'id', 'fechaCreacion', 'paciente', 'medico'
        ]
    ];

    public function initialize()
    {
        parent::initialize();
        $this->Auth->allow(['fichas', 'view', 'fichasMedico', 'numeroFichas', 'delete', 'getFichaPaciente', 'cambiarMedico']);
        $this->loadComponent('Csrf');
    }

    public function beforeFilter(Event $event) {
        
            $this->eventManager()->off($this->Csrf);   
    }

    public function fichas()
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
            if(isset($data['filtro']['fechaInicio'])){
                $fechaInicio =  array('fechaCreacion >' => $data['filtro']['fechaInicio']);
            }else{
                $fechaInicio = "";
            }
            if(isset($data['filtro']['fechaFin'])){
                $fechaFin =  array('fechaCreacion <' => $data['filtro']['fechaFin']);
            }else{
                $fechaFin = "";
            }
            
            if(isset($data['filtro']['id'])){
                $conditions = array('id' => $data['filtro']['id'],$fechaFin, $fechaFin);
            }else{
                $conditions = array($fechaInicio, $fechaFin);
            }  
        } 

        $fichas = $this->Ficha->find('all', array('conditions' => $conditions));
        $paginador = $this->paginate($fichas);

        foreach($paginador as $ficha){
            
            $usuarios = TableRegistry::getTableLocator()->get('User');
            $iteradorUsuarios = $usuarios->find()->where(['id' => $ficha['paciente']])->all();
            foreach($iteradorUsuarios as $usuario){
                $ficha['dniPaciente'] = $usuario['dni'];
                $ficha['nombrePaciente'] = $usuario['nombre']." ".$usuario['apellidos'];
            }
            $iteradorUsuarios2 = $usuarios->find()->where(['id' => $ficha['medico']])->all();
            foreach($iteradorUsuarios2 as $usuario2){
                $ficha['dniMedico'] = $usuario2['dni'];
                $ficha['nombreMedico'] = $usuario2['nombre']." ".$usuario2['apellidos'];
                $ficha['colegiado'] = $usuario2['colegiado'];
            }
            $enfermedad = TableRegistry::getTableLocator()->get('FichaEnfermedad');
            $iteradorEnfermedad = $enfermedad->find()->where(['ficha' => $ficha['id']])->all();

            foreach($iteradorEnfermedad as $enfermedad){
                $ficha['enfermedad'] = $enfermedad['enfermedad'];
            }
            $fecha = FrozenTime::parse($ficha->fechaCreacion);
            $ficha->fechaCreacion = $fecha;
            $ficha->fechaCreacion = $ficha->fechaCreacion->i18nFormat('dd/MM/YYYY');
        }
       
        $this->response->statusCode(200);
        $this->response->type('json');
        $json = json_encode($paginador);
        $this->response->body($json);
    }


    public function numeroFichas()
    {

        $this->autoRender = false;
        $conditions = array();
        $fichas = $this->Ficha->find('all', array('conditions' => $conditions));

        $i = 0;

        foreach($fichas as $ficha){
            $i++;
        }

        $myobj = array();
        $myobj['numero'] = $i;

       
        $this->response->statusCode(200);
        $this->response->type('json');
        $json = json_encode($myobj);
        $this->response->body($json);
    }

    

    public function fichasMedico()
    {
        $this->autoRender = false;
        $data = $this->request->getData();
        $this->paginate['page'] = $data['page']+1;
        $this->paginate['limit'] = $data['limit'];

        if(isset($data['tipo'])){
            $this->paginate['order'] = [$data['tipo'] => 'desc'];
        }

        $usuarios2 = TableRegistry::getTableLocator()->get('User');
        $iteradorUsuarios = $usuarios2->find()->where(['username' => $data['medico']])->all();
        foreach($iteradorUsuarios as $user){
                $idUsuario = $user['id'];
        }


        if(!isset($data['filtro'])){
            $conditions = array('medico' => $idUsuario);
        }else{
            if(isset($data['filtro']['fechaInicio'])){
                $fechaInicio =  array('fechaCreacion >' => $data['filtro']['fechaInicio']);
            }else{
                $fechaInicio = "";
            }
            if(isset($data['filtro']['fechaFin'])){
                $fechaFin =  array('fechaCreacion <' => $data['filtro']['fechaFin']);
            }else{
                $fechaFin = "";
            }
            if(isset($data['filtro']['id'])){
                $conditions = array('medico' => $idUsuario,'id' => $data['filtro']['id'],$fechaFin, $fechaFin);
            }else{
                $conditions = array('medico' => $idUsuario,$fechaInicio, $fechaFin);
            }  
        } 

        $fichas = $this->Ficha->find('all', array('conditions' => $conditions));
        $paginador = $this->paginate($fichas);

        foreach($paginador as $ficha){
            
            $usuarios = TableRegistry::getTableLocator()->get('User');
            $iteradorUsuarios = $usuarios->find()->where(['id' => $ficha['paciente']])->all();
            foreach($iteradorUsuarios as $usuario){
                $ficha['dniPaciente'] = $usuario['dni'];
                $ficha['nombrePaciente'] = $usuario['nombre']." ".$usuario['apellidos'];
            }
            $iteradorUsuarios2 = $usuarios->find()->where(['id' => $ficha['medico']])->all();
            foreach($iteradorUsuarios2 as $usuario2){
                $ficha['dniMedico'] = $usuario2['dni'];
                $ficha['nombreMedico'] = $usuario2['nombre']." ".$usuario2['apellidos'];
                $ficha['colegiado'] = $usuario2['colegiado'];
            }
            $enfermedad = TableRegistry::getTableLocator()->get('FichaEnfermedad');
            $iteradorEnfermedad = $enfermedad->find()->where(['ficha' => $ficha['id']])->all();

            foreach($iteradorEnfermedad as $enfermedad){
                $ficha['enfermedad'] = $enfermedad['enfermedad'];
            }
            $fecha = FrozenTime::parse($ficha->fechaCreacion);
            $ficha->fechaCreacion = $fecha;
            $ficha->fechaCreacion = $ficha->fechaCreacion->i18nFormat('dd/MM/YYYY');
        }
       
        $this->response->statusCode(200);
        $this->response->type('json');
        $json = json_encode($paginador);
        $this->response->body($json);
    }

    /**
     * View method
     *
     * @param string|null $id Ficha id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $this->autoRender = false;
        $ficha = $this->Ficha->get($id);
        
        $enfermedades = array();

        $fichaEnfermedad = TableRegistry::getTableLocator()->get('FichaEnfermedad');
        $iteradorEnfermedades = $fichaEnfermedad->find()->where(['ficha' => $id])->all();
        $i = 0;
        foreach($iteradorEnfermedades as $enfermedad){
            $enfermedades[$i++] = $enfermedad['enfermedad'];
        }

        $ficha['enfermedad'] = (object) $enfermedades;

        $fecha = FrozenTime::parse($ficha->fechaCreacion);
        $ficha->fechaCreacion = $fecha;
        $ficha->fechaCreacion = $ficha->fechaCreacion->i18nFormat('dd/MM/YYYY');


        $this->response->statusCode(200);
        $this->response->type('json');
        $json = json_encode($ficha);
        $this->response->body($json);
    }


    /*
    Devuelve el numero de ficha de paciente
    */
    public function getFichaPaciente($id = null)
    {
        $this->autoRender = false;
        $iteradorFicha = $this->Ficha->find()->where(['paciente' => $id])->all();
        
        foreach($iteradorFicha as $ficha){
            $enfermedades = array();

            $fichaEnfermedad = TableRegistry::getTableLocator()->get('FichaEnfermedad');
            $iteradorEnfermedades = $fichaEnfermedad->find()->where(['ficha' => $ficha['id']])->all();
            $i = 0;
            foreach($iteradorEnfermedades as $enfermedad){
                $enfermedades[$i++] = $enfermedad['enfermedad'];
            }
    
            $ficha['enfermedad'] = (object) $enfermedades;
    
            $fecha = FrozenTime::parse($ficha->fechaCreacion);
            $ficha->fechaCreacion = $fecha;
            $ficha->fechaCreacion = $ficha->fechaCreacion->i18nFormat('dd/MM/YYYY');
            $fichaAEnviar = array($ficha);
        }

        $this->response->statusCode(200);
        $this->response->type('json');
        $json = json_encode($fichaAEnviar);
        $this->response->body($json);
    }


    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $ficha = $this->Ficha->newEntity();
        if ($this->request->is('post')) {
            $ficha = $this->Ficha->patchEntity($ficha, $this->request->getData());
            if ($this->Ficha->save($ficha)) {
                $this->Flash->success(__('The ficha has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The ficha could not be saved. Please, try again.'));
        }
        $enfermedad = $this->Ficha->Enfermedad->find('list', ['limit' => 200]);
        $this->set(compact('ficha', 'enfermedad'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Ficha id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $ficha = $this->Ficha->get($id, [
            'contain' => ['Enfermedad'],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $ficha = $this->Ficha->patchEntity($ficha, $this->request->getData());
            if ($this->Ficha->save($ficha)) {
                $this->Flash->success(__('The ficha has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The ficha could not be saved. Please, try again.'));
        }
        $enfermedad = $this->Ficha->Enfermedad->find('list', ['limit' => 200]);
        $this->set(compact('ficha', 'enfermedad'));
    }

    /*
    permite asignar un medico a un paciente
    */
    public function cambiarMedico()
    {
        $this->autoRender = false;
        $data = $this->request->getData();
        $ficha = $this->Ficha->get($data['id']);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $ficha = $this->Ficha->patchEntity($ficha, $this->request->getData());
            if ($this->Ficha->save($ficha)) {
                $this->response->statusCode(200);
                $this->response->type('json');
                $json = json_encode($ficha);
                $this->response->body($json);
            }else{
                $this->response->statusCode(500);
                $this->response->type('json');
                $json = json_encode($ficha->errors());
                $this->response->body($json);
            }  
        }
    }

    /**
     * Delete method
     *
     * @param string|null $id Ficha id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    { 
        $this->autoRender = false;
        $ficha = $this->Ficha->get($id);
        $this->Ficha->delete($ficha);

        $this->response->statusCode(200);
        $this->response->type('json');
        $json = json_encode($ficha);
        $this->response->body($json);

    }
}
