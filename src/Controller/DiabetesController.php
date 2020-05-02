<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;
use Cake\Event\Event;
use Cake\I18n\FrozenTime;
use Cake\Utility\Security;

/**
 * Diabetes Controller
 *
 * @property \App\Model\Table\DiabetesTable $Diabetes
 *
 * @method \App\Model\Entity\Diabetes[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class DiabetesController extends AppController
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
            'id', 'fecha', 'numeroControles', 'nivelBajo', 'frecuenciaBajo',
            'horarioBajo', 'perdidaConocimiento', 'nivelAlto', 'frecuenciaAlto', 'horarioAlto',
            'actividadFisica', 'problemaDieta', 'estadoGeneral'
        ],
        'sortWhitelist' => [
            'id', 'fecha', 'numeroControles', 'nivelBajo', 'frecuenciaBajo',
            'horarioBajo', 'perdidaConocimiento', 'nivelAlto', 'frecuenciaAlto', 'horarioAlto',
            'actividadFisica', 'problemaDieta', 'estadoGeneral'
        ]
    ];

    
    public function initialize()
    {
        parent::initialize();
        $this->Auth->allow(['diabetesFichas', 'numeroInformesDiabetes', 'view', 'todosDiabetesFichas', 'getCubierto', 'add']);
        $this->loadComponent('Csrf');
    }

    public function beforeFilter(Event $event) {
        
        $this->eventManager()->off($this->Csrf);   
    }


    public function diabetesFichas()
    {

        $this->autoRender = false;
        $data = $this->request->getData();
        $this->paginate['page'] = $data['page']+1;
        $this->paginate['limit'] = $data['limit'];

        $conditions = array('ficha' => $data['id']);

        $diabetes = $this->Diabetes->find('all', array('conditions' => $conditions));
        $paginador = $this->paginate($diabetes);

        foreach($paginador as $diabetes){

            $fecha = FrozenTime::parse($diabetes['fecha']);
            $diabetes->fecha = $fecha;
            
            $diabetes->fecha =  $diabetes->fecha->i18nFormat('dd/MM/YYYY HH:mm');
            
            $momentos = TableRegistry::getTableLocator()->get('Momentos');
            $momentosIterador = $momentos->find()->where(['diabetes' => $diabetes['id']])->all();

            foreach($momentosIterador as $momento){
                unset($momento['diabetes']);
                $momento = $this->desencriptarMomento($momento);
            }
            
            $diabetes['momentos'] = $momentosIterador;

            $diabetes = $this->desencriptarInforme($diabetes);
        }
       
        $this->response->statusCode(200);
        $this->response->type('json');
        $json = json_encode($paginador);
        $this->response->body($json);

    }

    public function todosDiabetesFichas()
    {

        $this->autoRender = false;
        $data = $this->request->getData();

        $conditions = array('ficha' => $data['id']);

        $diabetesInformes = $this->Diabetes->find()->where(['ficha' => $data['id']])->all();

        foreach($diabetesInformes as $diabetes){

            $fecha = FrozenTime::parse($diabetes['fecha']);
            $diabetes->fecha = $fecha;
            
            $diabetes->fecha =  $diabetes->fecha->i18nFormat('dd/MM/YYYY HH:mm');
            
            $momentos = TableRegistry::getTableLocator()->get('Momentos');
            $momentosIterador = $momentos->find()->where(['diabetes' => $diabetes['id']])->all();

            foreach($momentosIterador as $momento){
                unset($momento['diabetes']);
                $momento = $this->desencriptarMomento($momento);   
            }
            
            $diabetes['momentos'] = $momentosIterador;

            $diabetes = $this->desencriptarInforme($diabetes);
        }
       
        $this->response->statusCode(200);
        $this->response->type('json');
        $json = json_encode($diabetesInformes);
        $this->response->body($json);

    }

    public function numeroInformesDiabetes()
    {

        $this->autoRender = false;
        $data = $this->request->getData();

        $conditions = array('ficha' => $data['id']);

        $diabetes = $this->Diabetes->find('all', array('conditions' => $conditions));

        $i = 0;

        foreach($diabetes as $diabetes){
            $i++;
        }

        $myobj = array();
        $myobj['numero'] = $i;
       
        $this->response->statusCode(200);
        $this->response->type('json');
        $json = json_encode($myobj);
        $this->response->body($json);

    }

    /**
     * View method
     *
     * @param string|null $id Diabetes id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $this->autoRender = false;
        $diabetes = $this->Diabetes->get($id);

        $fecha = FrozenTime::parse($diabetes['fecha']);
        $diabetes->fecha = $fecha;
        
        $diabetes->fecha =  $diabetes->fecha->i18nFormat('dd/MM/YYYY HH:mm');
        
        $momentos = TableRegistry::getTableLocator()->get('Momentos');
        $momentosIterador = $momentos->find()->where(['diabetes' => $diabetes['id']])->all();

        foreach($momentosIterador as $momento){
            unset($momento['diabetes']);
            $momento = $this->desencriptarMomento($momento);
        }
        
        $diabetes['momentos'] = $momentosIterador;

        $diabetes = $this->desencriptarInforme($diabetes);

        $this->response->statusCode(200);
        $this->response->type('json');
        $json = json_encode($diabetes);
        $this->response->body($json);
    }

    /**
     * Edit method
     *
     * @param string|null $id Diabetes id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $diabetes = $this->Diabetes->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $diabetes = $this->Diabetes->patchEntity($diabetes, $this->request->getData());
            if ($this->Diabetes->save($diabetes)) {
                $this->Flash->success(__('The diabetes has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The diabetes could not be saved. Please, try again.'));
        }
        $this->set(compact('diabetes'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Diabetes id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $diabetes = $this->Diabetes->get($id);
        if ($this->Diabetes->delete($diabetes)) {
            $this->Flash->success(__('The diabetes has been deleted.'));
        } else {
            $this->Flash->error(__('The diabetes could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function getCubierto($id = null)
    {
    
        $this->autoRender = false;
        $cubierto['cubierto'] = false;

        $fecha = FrozenTime::now();
        
        $fecha =  $fecha->i18nFormat('YYYY-MM-dd');

        $informes = $this->Diabetes->find()->where(['fecha LIKE' => '%'.$fecha.'%'])->where(['ficha' => $id])->all();
        if(sizeof($informes) > 0){
            $cubierto['cubierto'] = true;
        }
       
        $this->response->statusCode(200);
        $this->response->type('json');
        $json = json_encode($cubierto);
        $this->response->body($json);

    }

    public function add()
    {
        $this->autoRender = false;
        $fecha = FrozenTime::now();
        $fecha =  $fecha->i18nFormat('YYYY-MM-dd HH:MM:ss');
        $data = $this->request->getData();
        $data['fecha'] = $fecha;
        $diabetes = $this->Diabetes->newEntity();
        $diabetes = $this->Diabetes->patchEntity($diabetes, $data);
        $result = $this->Diabetes->save($diabetes);
        if($result){
            $diabetes['id'] = $result->id;
            $this->response->statusCode(200);
            $this->response->type('json');
            $json = json_encode($diabetes);
            $this->response->body($json);
        }else{
            header('Access-Control-Allow-Origin: *');
            $this->response->statusCode(500);
            header('Content-Type: application/json');
            $this->set('problema', 'Error al crear la consulta');    
            $this->set('_serialize', ['problema']); 
        } 
    }

    public function desencriptarInforme($diabetes){
        $diabetes['numeroControles'] = Security::decrypt(base64_decode($diabetes['numeroControles']), Security::salt());
        $diabetes['nivelBajo'] = Security::decrypt(base64_decode($diabetes['nivelBajo']), Security::salt());
        $diabetes['frecuenciaBajo'] = Security::decrypt(base64_decode($diabetes['frecuenciaBajo']), Security::salt());
        $diabetes['horarioBajo'] = Security::decrypt(base64_decode($diabetes['horarioBajo']), Security::salt());
        $diabetes['perdidaConocimiento'] = Security::decrypt(base64_decode($diabetes['perdidaConocimiento']), Security::salt());
        $diabetes['nivelAlto'] = Security::decrypt(base64_decode($diabetes['nivelAlto']), Security::salt());
        $diabetes['frecuenciaAlto'] = Security::decrypt(base64_decode($diabetes['frecuenciaAlto']), Security::salt());
        $diabetes['horarioAlto'] = Security::decrypt(base64_decode($diabetes['horarioAlto']), Security::salt());
        $diabetes['actividadFisica'] = Security::decrypt(base64_decode($diabetes['actividadFisica']), Security::salt());
        $diabetes['problemaDieta'] = Security::decrypt(base64_decode($diabetes['problemaDieta']), Security::salt());
        $diabetes['estadoGeneral'] = Security::decrypt(base64_decode($diabetes['estadoGeneral']), Security::salt());

        return $diabetes;
    }

    public function desencriptarMomento($momento){
        $momento['momento'] = Security::decrypt(base64_decode($momento['momento']), Security::salt());

        return $momento;
    }
}
