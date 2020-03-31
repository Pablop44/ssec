<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;
use Cake\Event\Event;
use Cake\I18n\FrozenTime;

/**
 * Migranas Controller
 *
 * @property \App\Model\Table\MigranasTable $Migranas
 *
 * @method \App\Model\Entity\Migrana[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class MigranasController extends AppController
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
            'id', 'fecha', 'frecuencia', 'duracion', 'horario',
            'finalizacion', 'tipoEpisodio', 'intensidad', 'limitaciones', 'despiertoNoche',
            'estadoGeneral'
        ],
        'sortWhitelist' => [
            'id', 'fecha', 'frecuencia', 'duracion', 'horario',
            'finalizacion', 'tipoEpisodio', 'intensidad', 'limitaciones', 'despiertoNoche',
            'estadoGeneral'
        ]
    ];

    
    public function initialize()
    {
        parent::initialize();
        $this->Auth->allow(['migranasFichas', 'numeroInformesMigranas', 'view']);
        $this->loadComponent('Csrf');
    }

    public function beforeFilter(Event $event) {
        
        $this->eventManager()->off($this->Csrf);   
    }

    /**
     * View method
     *
     * @param string|null $id Migrana id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function migranasFichas()
    {

        $this->autoRender = false;
        $data = $this->request->getData();
        $this->paginate['page'] = $data['page']+1;
        $this->paginate['limit'] = $data['limit'];

        $conditions = array('ficha' => $data['id']);

        $migranas = $this->Migranas->find('all', array('conditions' => $conditions));
        $paginador = $this->paginate($migranas);

        foreach($paginador as $migranas){

            $fecha = FrozenTime::parse($migranas['fecha']);
            $migranas->fecha = $fecha;
            
            $migranas->fecha =  $migranas->fecha->i18nFormat('dd/MM/YYYY HH:mm');
            
            $sintomas = TableRegistry::getTableLocator()->get('Sintomas');
            $sintomasIterador = $sintomas->find()->where(['migranas' => $migranas['id']])->all();

            foreach($sintomasIterador as $sintomas){
                unset($sintomas['migranas']);
            }

            $migranas['sintomas'] = $sintomasIterador;

            $factores = TableRegistry::getTableLocator()->get('Factores');
            $factoresIterador = $factores->find()->where(['migranas' => $migranas['id']])->all();

            foreach($factoresIterador as $factores){
                unset($factores['migranas']);
            }

            $migranas['factores'] = $factoresIterador;
            
        }
       
        $this->response->statusCode(200);
        $this->response->type('json');
        $json = json_encode($paginador);
        $this->response->body($json);

    }

    public function numeroInformesMigranas()
    {

        $this->autoRender = false;
        $data = $this->request->getData();

        $conditions = array('ficha' => $data['id']);

        $migranas = $this->Migranas->find('all', array('conditions' => $conditions));

        $i = 0;

        foreach($migranas as $migranas){
            $i++;
        }

        $myobj = array();
        $myobj['numero'] = $i;
       
        $this->response->statusCode(200);
        $this->response->type('json');
        $json = json_encode($myobj);
        $this->response->body($json);

    }
    
    public function view($id = null){

        $this->autoRender = false;
        $migranas = $this->Migranas->get($id);
    

        $fecha = FrozenTime::parse($migranas['fecha']);
        $migranas->fecha = $fecha;
        
        $migranas->fecha =  $migranas->fecha->i18nFormat('dd/MM/YYYY HH:mm');
        
        $sintomas = TableRegistry::getTableLocator()->get('Sintomas');
        $sintomasIterador = $sintomas->find()->where(['migranas' => $migranas['id']])->all();

        foreach($sintomasIterador as $sintomas){
            unset($sintomas['migranas']);
        }

        $migranas['sintomas'] = $sintomasIterador;

        $factores = TableRegistry::getTableLocator()->get('Factores');
        $factoresIterador = $factores->find()->where(['migranas' => $migranas['id']])->all();

        foreach($factoresIterador as $factores){
            unset($factores['migranas']);
        }

        $migranas['factores'] = $factoresIterador;
       
        $this->response->statusCode(200);
        $this->response->type('json');
        $json = json_encode($migranas);
        $this->response->body($json);
    }


    public function add()
    {
        $migrana = $this->Migranas->newEntity();
        if ($this->request->is('post')) {
            $migrana = $this->Migranas->patchEntity($migrana, $this->request->getData());
            if ($this->Migranas->save($migrana)) {
                $this->Flash->success(__('The migrana has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The migrana could not be saved. Please, try again.'));
        }
        $this->set(compact('migrana'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Migrana id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $migrana = $this->Migranas->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $migrana = $this->Migranas->patchEntity($migrana, $this->request->getData());
            if ($this->Migranas->save($migrana)) {
                $this->Flash->success(__('The migrana has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The migrana could not be saved. Please, try again.'));
        }
        $this->set(compact('migrana'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Migrana id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $migrana = $this->Migranas->get($id);
        if ($this->Migranas->delete($migrana)) {
            $this->Flash->success(__('The migrana has been deleted.'));
        } else {
            $this->Flash->error(__('The migrana could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
