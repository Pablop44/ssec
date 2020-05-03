<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;
use Cake\I18n\FrozenTime;
use Cake\Event\Event;
use Cake\I18n\Time;
use Cake\Utility\Security;

/**
 * Consulta Controller
 *
 * @property \App\Model\Table\ConsultaTable $Consulta
 *
 * @method \App\Model\Entity\Consultum[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ConsultaController extends AppController
{
    public $paginate = [
        'page' => 1,
        'limit' => 10,
        'maxLimit' => 15,
        'fields' => [
            'id', 'lugar', 'motivo', 'fecha', 'diagnostico', 'observaciones', 'medico', 'paciente', 'ficha', 'estado' 
        ],
        'sortWhitelist' => [
            'id', 'lugar', 'motivo', 'fecha', 'diagnostico', 'observaciones', 'medico', 'paciente', 'ficha', 'estado' 
        ]
    ];
    
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */

    public function initialize()
    {
        parent::initialize();
        $this->loadComponent('Csrf');
        $this->Auth->allow(['view', 'editarConsulta', 'getHorasPaciente', 'add']);
        $this->loadComponent('Paginator');
    }

    public function beforeFilter(Event $event) {
        
        $this->eventManager()->off($this->Csrf);
    
    }

    public function consultas()
    {
        $this->autoRender = false;
        $data = $this->request->getData();

        $this->paginate['page'] = $data['page']+1;
        $this->paginate['limit'] = $data['limit'];
        if(isset($data['tipo'])){
            $this->paginate['order'] = [$data['tipo'] => 'desc'];
        }

        $this->response->statusCode(200);
        $this->response->type('json');
        $paginador = $this->paginate($this->Consulta);
        foreach($paginador as $consulta){
            $fecha = FrozenTime::parse($consulta['fecha']);
            $consulta->fecha = $fecha;
            $consulta->fecha =  $consulta->fecha->i18nFormat('dd/MM/YYYY HH:mm');
            $consulta = $this->desencriptarConsulta($consulta);
        }
        $json = json_encode($paginador);
        $this->response->body($json);
    }

    public function numeroConsultasTodas()
    {
        $this->autoRender = false;
        $data = $this->request->getData();

        $i = 0;
        $iterador = $this->Consulta->find()->all();
        foreach($iterador as $consulta){
            $i++;
        }

        $array = array();
        $array['numero'] = $i;

        $this->response->statusCode(200);
        $this->response->type('json');
        $json = json_encode($array);
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
        $this->autoRender = false;
        $consultum = $this->Consulta->get($id, [
            'contain' => [],
        ]);

        $fecha = FrozenTime::parse($consultum['fecha']);
        $consultum->fecha = $fecha;
            
        $consultum->fecha =  $consultum->fecha->i18nFormat('dd-MM-YYYY HH:mm');

        $consultum = $this->desencriptarConsulta($consultum);
        $this->response->statusCode(200);
        $this->response->type('json');
        $json = json_encode($consultum);
        $this->response->body($json);
    }

    public function consultaFicha()
    {
        $this->autoRender = false;

        $data = $this->request->getData();

        $this->paginate['page'] = $data['page']+1;
        $this->paginate['limit'] = $data['limit'];
        if(isset($data['tipo'])){
            $this->paginate['order'] = [$data['tipo'] => 'desc'];
        }

        if(!isset($data['filtro'])){
            $conditions = array('ficha' => $data['id']);
        }else{

            if(isset($data['filtro']['observaciones'])){
                $observarciones =  array('observaciones IS NOT NULL');
            }else{
                $observarciones =  array('observaciones IS NULL');
            }
    
            if(isset($data['filtro']['diagnostico'])){
                $diagnostico =  array('diagnostico IS NOT NULL');
            }else{
                $diagnostico =  array('diagnostico IS NULL');
            }

            if(isset($data['filtro']['fechaInicio'])){
                $fechaInicio =  array('fecha >' => $data['filtro']['fechaInicio']);
            }else{
                $fechaInicio = "";
            }

            if(isset($data['filtro']['fechaFin'])){
                $fechaFin =  array('fecha <' => $data['filtro']['fechaFin']);
            }else{
                $fechaFin = "";
            }
    
            if(isset($data['filtro']['id'])){
                $conditions = array('ficha' => $data['id'], "id" => $data['filtro']['id'], "lugar LIKE" => "%".$data['filtro']['lugar']."%", $observarciones, $diagnostico, $fechaInicio, $fechaFin);
            }else{
                $conditions = array('ficha' => $data['id'], "lugar LIKE" => "%".$data['filtro']['lugar']."%", $observarciones, $diagnostico, $fechaInicio, $fechaFin);
            }
            
        }
        

        $consultas = $this->Consulta->find('all', array('conditions' => $conditions));
        $paginador = $this->paginate($consultas);

        foreach($paginador as $consulta){
            $fecha = FrozenTime::parse($consulta['fecha']);
            $consulta->fecha = $fecha;
            $consulta->fecha =  $consulta->fecha->i18nFormat('dd/MM/YYYY HH:mm');
            $consulta = $this->desencriptarConsulta($consulta);
        }
    
        $this->response->statusCode(200);
        $this->response->type('json');
        $json = json_encode($paginador);
        $this->response->body($json);
    }

    public function numeroConsultas()
    {
        $this->autoRender = false;

        $data = $this->request->getData();

        if(!isset($data['filtro'])){
            $conditions = array('ficha' => $data['id']);
        }else{

            if(isset($data['filtro']['observaciones'])){
                $observarciones =  array('observaciones IS NOT NULL');
            }else{
                $observarciones =  array('observaciones IS NULL');
            }
    
            if(isset($data['filtro']['diagnostico'])){
                $diagnostico =  array('diagnostico IS NOT NULL');
            }else{
                $diagnostico =  array('diagnostico IS NULL');
            }

            if(isset($data['filtro']['fechaInicio'])){
                $fechaInicio =  array('fecha >' => $data['filtro']['fechaInicio']);
            }else{
                $fechaInicio = "";
            }

            if(isset($data['filtro']['fechaFin'])){
                $fechaFin =  array('fecha <' => $data['filtro']['fechaFin']);
            }else{
                $fechaFin = "";
            }
    
            if(isset($data['filtro']['id'])){
                $conditions = array('ficha' => $data['id'], "id" => $data['filtro']['id'], "lugar LIKE" => "%".$data['filtro']['lugar']."%", $observarciones, $diagnostico, $fechaInicio, $fechaFin);
            }else{
                $conditions = array('ficha' => $data['id'], "lugar LIKE" => "%".$data['filtro']['lugar']."%", $observarciones, $diagnostico, $fechaInicio, $fechaFin);
            }
            
        }

        $this->autoRender = false;
        $consultas = $this->Consulta->find('all', array('conditions' => $conditions));
        $i = 0;
        foreach($consultas as $consulta){
           $i++;
        }

        $myobj = array();
        $myobj['numero'] = $i;
        
    
        $this->response->statusCode(200);
        $this->response->type('json');
        $json = json_encode($myobj);
        $this->response->body($json);
    }

    public function getHoras()
    {
        $this->autoRender = false;
        $data = $this->request->getData();
    
        $fechaPrueba = FrozenTime::parse($data['fecha']);

        if(!$fechaPrueba->isPast()){

            $consultas = $this->Consulta->find()->where(['fecha LIKE' => '%'.$data['fecha'].'%'])->where(['medico' => $data['medico']])->all();
            $horas = array();
            $horas['09:00'] = false;
            $horas['10:00'] = false;
            $horas['11:00'] = false;
            $horas['12:00'] = false;
            $horas['13:00'] = false;
            $horas['14:00'] = false;
            $horas['15:00'] = false;
            $horas['16:00'] = false;
            foreach($consultas as $consulta){

            $fecha = FrozenTime::parse($consulta['fecha']);
            $consulta->fecha = $fecha;
            
            $consulta->fecha =  $consulta->fecha->i18nFormat('dd/MM/YYYY HH:mm:ss');
                if(strpos($consulta->fecha, '09:00:00')){
                    $horas['09:00'] = true;
                   }
                   if(strpos($consulta->fecha, '10:00:00')){
                    $horas['10:00'] = true;
                   }
                   if(strpos($consulta->fecha, '11:00:00')){
                    $horas['11:00'] = true;
                   }
                   if(strpos($consulta->fecha, '12:00:00')){
                    $horas['12:00'] = true;
                   }
                   if(strpos($consulta->fecha, '13:00:00')){
                    $horas['13:00'] = true;
                   }
                   if(strpos($consulta->fecha, '14:00:00')){
                    $horas['14:00'] = true;
                   }
                   if(strpos($consulta->fecha, '15:00:00')){
                    $horas['15:00'] = true;
                   }
                   if(strpos($consulta->fecha, '16:00:00')){
                    $horas['16:00'] = true;
                   }
             }
            
        }else{
            $horas['09:00'] = true;
            $horas['10:00'] = true;
            $horas['11:00'] = true;
            $horas['12:00'] = true;
            $horas['13:00'] = true;
            $horas['14:00'] = true;
            $horas['15:00'] = true;
            $horas['16:00'] = true;
        }
    
        $this->response->statusCode(200);
        $this->response->type('json');
        $json = json_encode($horas);
        $this->response->body($json);
        
    }

    public function getHorasPaciente()
    {
        $this->autoRender = false;
        $data = $this->request->getData();
        
        $fechaPrueba = FrozenTime::parse($data['fecha']);

        if(!$fechaPrueba->isPast()){

            $fichas = TableRegistry::getTableLocator()->get('Ficha');
            $iterador = $fichas->find()->where(['id' => $data['ficha']])->all();
            foreach($iterador as $usuario){
                $medico = $usuario['medico'];
            }

            $consultas = $this->Consulta->find()->where(['fecha LIKE' => '%'.$data['fecha'].'%'])->where(['medico' => $medico])->all();
            $horas = array();
            $hora['hora'] = "09:00";
            $hora['disponible'] = "false";
            array_push($horas, $hora);
            $hora['hora'] = "10:00";
            $hora['disponible'] = "false";
            array_push($horas, $hora);
            $hora['hora'] = "11:00";
            $hora['disponible'] = "false";
            array_push($horas, $hora);
            $hora['hora'] = "12:00";
            $hora['disponible'] = "false";
            array_push($horas, $hora);
            $hora['hora'] = "13:00";
            $hora['disponible'] = "false";
            array_push($horas, $hora);
            $hora['hora'] = "14:00";
            $hora['disponible'] = "false";
            array_push($horas, $hora);
            $hora['hora'] = "15:00";
            $hora['disponible'] = "false";
            array_push($horas, $hora);
            $hora['hora'] = "16:00";
            $hora['disponible'] = "false";
            array_push($horas, $hora);
            
            foreach($consultas as $consulta){

            $fecha = FrozenTime::parse($consulta['fecha']);
            $consulta->fecha = $fecha;
            
            $consulta->fecha = $consulta->fecha->i18nFormat('dd/MM/YYYY HH:mm:ss');
                if(strpos($consulta->fecha, '09:00:00')){
                    $horas[0]['hora'] = "09:00";
                    $horas[0]['disponible'] = "true";
                   }
                   if(strpos($consulta->fecha, '10:00:00')){
                    $horas[1]['hora'] = "10:00";
                    $horas[1]['disponible'] = "true";
                   }
                   if(strpos($consulta->fecha, '11:00:00')){
                    $horas[2]['hora'] = "11:00";
                    $horas[2]['disponible'] = "true";
                   }
                   if(strpos($consulta->fecha, '12:00:00')){
                    $horas[3]['hora'] = "12:00";
                    $horas[3]['disponible'] = "true";   
                   }
                   if(strpos($consulta->fecha, '13:00:00')){
                    $horas[4]['hora'] = "13:00";
                    $horas[4]['disponible'] = "true";
                   }
                   if(strpos($consulta->fecha, '14:00:00')){
                    $horas[5]['hora'] = "14:00";
                    $horas[5]['disponible'] = "true";
                   }
                   if(strpos($consulta->fecha, '15:00:00')){
                    $horas[6]['hora'] = "15:00";
                    $horas[6]['disponible'] = "true";
                   }
                   if(strpos($consulta->fecha, '16:00:00')){
                    $horas[7]['hora'] = "16:00";
                    $horas[7]['disponible'] = "true";
                    }
            }
        }else{

            $horas[0]['hora'] = "09:00";
            $horas[0]['disponible'] = "true";
            $horas[1]['hora'] = "10:00";
            $horas[1]['disponible'] = "true";
            $horas[2]['hora'] = "11:00";
            $horas[2]['disponible'] = "true";
            $horas[3]['hora'] = "12:00";
            $horas[3]['disponible'] = "true";
            $horas[4]['hora'] = "13:00";
            $horas[4]['disponible'] = "true";
            $horas[5]['hora'] = "14:00";
            $horas[5]['disponible'] = "true";
            $horas[6]['hora'] = "15:00";
            $horas[6]['disponible'] = "true";
            $horas[7]['hora'] = "16:00";
            $horas[7]['disponible'] = "true";
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
        $this->autoRender = false;
        header('Access-Control-Allow-Origin: *');
        $consulta = $this->request->getData();
        $consultum = $this->Consulta->newEntity();

        $consultum['fecha'] = $consulta['fecha'];
        $consultum['observaciones'] = null;
        $consultum['diagnostico'] = null;
        $consultum['id'] = null;
        if(!isset($consulta['lugar'])){
            $consultum['lugar'] = null;
        }else{
            $consultum['lugar'] = $consulta['lugar'];
        }

        if(!isset($consulta['medico'])){
            $fichas = TableRegistry::getTableLocator()->get('Ficha');
            $iterador = $fichas->find()->where(['id' => $consulta['ficha']])->all();
            foreach($iterador as $usuario){
                $medico = $usuario['medico'];
                $paciente = $usuario['paciente'];
            }
            $consultum['medico'] = $medico;
            $consultum['paciente'] = $paciente;

        }else{
            $consultum['medico'] = $consulta['medico'];
            $consultum['paciente'] = $consulta['paciente'];
        }
        $consultum['motivo'] = $consulta['motivo'];
        $consultum['ficha'] = $consulta['ficha'];
        $consultum['estado'] = $consulta['estado'];

            if ($this->Consulta->save($consultum)) {
                $this->response->statusCode(200);
                $this->response->type('json');
                $json = json_encode($consultum);
                $this->response->body($json);
            }else{
                header('Access-Control-Allow-Origin: *');
                $this->response->statusCode(500);
                header('Content-Type: application/json');
                $this->set('problema', 'Error al crear la consulta');    
                $this->set('_serialize', ['problema']); 
            }     
    }
    /**
     * Edit method
     *
     * @param string|null $id Consultum id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function editarConsulta()
    {
        $this->autoRender = false;
        $data = $this->request->getData();
        $consultum = $this->Consulta->get($data['id']);
        $consultum = $this->desencriptarConsulta($consultum);
        if(isset($consultum['fecha'])){
            $fecha = FrozenTime::parse($consultum['fecha']);
            $fecha = $fecha->i18nFormat('dd/MM/YYYY HH:mm');
        }
        $consultum = $this->Consulta->patchEntity($consultum, $data);
        if ($this->Consulta->save($consultum)) {
            $this->response->statusCode(200);
            $this->response->type('json');
            $consultum = $this->desencriptarConsulta($consultum);
            $consultum['fecha'] = $fecha;
            $json = json_encode($consultum);
            $this->response->body($json);
        }
        if(empty($consultum->errors())){
            $this->response->statusCode(200);
            $this->response->type('json');
            $consultum = $this->desencriptarConsulta($consultum);
            $consultum['fecha'] = $fecha;
            $json = json_encode($consultum);
            $this->response->body($json);
        }else{
            $this->response->statusCode(500);
            $this->response->type('json');
            $json = json_encode($consultum->errors());
            $this->response->body($json);
        }
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


    public function consultasHoy($idMedico = null)
    {
        $this->autoRender = false;

        $time = FrozenTime::now();
        $time = $time->i18nFormat('YYYY-MM-dd');

        $consultas = $this->Consulta->find()->where(['medico' => $idMedico, "fecha LIKE" => "%".$time."%", 'estado' => 'en tiempo'])->order(['fecha' => 'DESC'])->all();
        foreach($consultas as $consulta){
            $user = TableRegistry::getTableLocator()->get('User');
            $iteradorUsuario2 = $user->find()->where(['id' => $consulta['paciente']])->all();
            foreach($iteradorUsuario2 as $usuario2){
                $consulta['paciente'] = $usuario2['nombre'].' '.$usuario2['apellidos'];
                $consulta['dniPaciente'] = $usuario2['dni'];
            }
            $fecha = FrozenTime::parse($consulta['fecha']);
            $consulta->fecha = $fecha;
            $consulta->fecha =  $consulta->fecha->i18nFormat('HH:mm');
            $consulta = $this->desencriptarConsulta($consulta);
        }

        $this->response->statusCode(200);
        $this->response->type('json');
        $json = json_encode($consultas);
        $this->response->body($json);
    }


    public function consultaMedico()
    {
        $this->autoRender = false;

        $data = $this->request->getData();

        $this->paginate['page'] = $data['page']+1;
        $this->paginate['limit'] = $data['limit'];
        if(isset($data['tipo'])){
            $this->paginate['order'] = [$data['tipo'] => 'desc'];
        }

        if(!isset($data['filtro'])){
            $conditions = array('medico' => $data['medico']);
        }else{

            if(isset($data['filtro']['observaciones'])){
                $observarciones =  array('observaciones IS NOT NULL');
            }else{
                $observarciones =  array('observaciones IS NULL');
            }
    
            if(isset($data['filtro']['diagnostico'])){
                $diagnostico =  array('diagnostico IS NOT NULL');
            }else{
                $diagnostico =  array('diagnostico IS NULL');
            }

            if(isset($data['filtro']['fechaInicio'])){
                $fechaInicio =  array('fecha >' => $data['filtro']['fechaInicio']);
            }else{
                $fechaInicio = "";
            }

            if(isset($data['filtro']['fechaFin'])){
                $fechaFin =  array('fecha <' => $data['filtro']['fechaFin']);
            }else{
                $fechaFin = "";
            }
    
            if(isset($data['filtro']['id'])){
                $conditions = array('medico' => $data['medico'], "id" => $data['filtro']['id'], "lugar LIKE" => "%".$data['filtro']['lugar']."%", $observarciones, $diagnostico, $fechaInicio, $fechaFin);
            }else{
                $conditions = array('medico' => $data['medico'], "lugar LIKE" => "%".$data['filtro']['lugar']."%", $observarciones, $diagnostico, $fechaInicio, $fechaFin);
            }  
        }

        $consultas = $this->Consulta->find('all', array('conditions' => $conditions));
        $paginador = $this->paginate($consultas);

        foreach($paginador as $consulta){
            $fecha = FrozenTime::parse($consulta['fecha']);
            $consulta->fecha = $fecha;
            $consulta->fecha =  $consulta->fecha->i18nFormat('dd/MM/YYYY HH:mm');
            $consulta = $this->desencriptarConsulta($consulta);

        }
    
        $this->response->statusCode(200);
        $this->response->type('json');
        $json = json_encode($paginador);
        $this->response->body($json);
    }
    
    public function numeroConsultasMedico()
    {
        $this->autoRender = false;

        $data = $this->request->getData();

        if(!isset($data['filtro'])){
            $conditions = array('medico' => $data['medico']);
        }else{

            if(isset($data['filtro']['observaciones'])){
                $observarciones =  array('observaciones IS NOT NULL');
            }else{
                $observarciones =  array('observaciones IS NULL');
            }
    
            if(isset($data['filtro']['diagnostico'])){
                $diagnostico =  array('diagnostico IS NOT NULL');
            }else{
                $diagnostico =  array('diagnostico IS NULL');
            }

            if(isset($data['filtro']['fechaInicio'])){
                $fechaInicio =  array('fecha >' => $data['filtro']['fechaInicio']);
            }else{
                $fechaInicio = "";
            }

            if(isset($data['filtro']['fechaFin'])){
                $fechaFin =  array('fecha <' => $data['filtro']['fechaFin']);
            }else{
                $fechaFin = "";
            }
    
            if(isset($data['filtro']['id'])){
                $conditions = array('medico' => $data['medico'], "id" => $data['filtro']['id'], "lugar LIKE" => "%".$data['filtro']['lugar']."%", $observarciones, $diagnostico, $fechaInicio, $fechaFin);
            }else{
                $conditions = array('medico' => $data['medico'], "lugar LIKE" => "%".$data['filtro']['lugar']."%", $observarciones, $diagnostico, $fechaInicio, $fechaFin);
            }
            
        }

        $this->autoRender = false;
        $consultas = $this->Consulta->find('all', array('conditions' => $conditions));
        $i = 0;
        foreach($consultas as $consulta){
           $i++;
        }

        $myobj = array();
        $myobj['numero'] = $i;
        
    
        $this->response->statusCode(200);
        $this->response->type('json');
        $json = json_encode($myobj);
        $this->response->body($json);
    }

    public function desencriptarConsulta($consulta){
        $consulta['motivo'] = Security::decrypt(base64_decode($consulta['motivo']), Security::salt());
        if($consulta['diagnostico'] != null){
            $consulta['diagnostico'] = Security::decrypt(base64_decode($consulta['diagnostico']), Security::salt());
        }
        if($consulta['observaciones']){
            $consulta['observaciones'] = Security::decrypt(base64_decode($consulta['observaciones']), Security::salt());
        }
        return $consulta;
    }
    
}
