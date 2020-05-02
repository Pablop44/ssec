<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;
use Cake\Event\Event;
use Cake\I18n\FrozenTime;
use Cake\Utility\Security;

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
                $sintomas = $this->desencriptarSintomas($sintomas);
            }

            $migranas['sintomas'] = $sintomasIterador;

            $factores = TableRegistry::getTableLocator()->get('Factores');
            $factoresIterador = $factores->find()->where(['migranas' => $migranas['id']])->all();

            foreach($factoresIterador as $factores){
                unset($factores['migranas']);
                $factores = $this->desencriptarFactores($factores);
            }

            $migranas['factores'] = $factoresIterador;
            $migranas = $this->desencriptarInforme($migranas);
            
        }
       
        $this->response->statusCode(200);
        $this->response->type('json');
        $json = json_encode($paginador);
        $this->response->body($json);

    }


    public function todosMigranasFichas()
    {

        $this->autoRender = false;
        $data = $this->request->getData();

        $migranasInformes = $this->Migranas->find()->where(['ficha' => $data['id']])->all();

        foreach($migranasInformes as $migranas){

            $fecha = FrozenTime::parse($migranas['fecha']);
            $migranas->fecha = $fecha;
            
            $migranas->fecha =  $migranas->fecha->i18nFormat('dd/MM/YYYY HH:mm');
            
            $sintomas = TableRegistry::getTableLocator()->get('Sintomas');
            $sintomasIterador = $sintomas->find()->where(['migranas' => $migranas['id']])->all();

            foreach($sintomasIterador as $sintomas){
                unset($sintomas['migranas']);
                $sintomas = $this->desencriptarSintomas($sintomas);
            }

            $migranas['sintomas'] = $sintomasIterador;

            $factores = TableRegistry::getTableLocator()->get('Factores');
            $factoresIterador = $factores->find()->where(['migranas' => $migranas['id']])->all();

            foreach($factoresIterador as $factores){
                unset($factores['migranas']);
                $factores = $this->desencriptarFactores($factores);
            }

            $migranas['factores'] = $factoresIterador;
            $migranas = $this->desencriptarInforme($migranas);
            
        }
       
        $this->response->statusCode(200);
        $this->response->type('json');
        $json = json_encode($migranasInformes);
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
            $sintomas = $this->desencriptarSintomas($sintomas);
        }

        $migranas['sintomas'] = $sintomasIterador;

        $factores = TableRegistry::getTableLocator()->get('Factores');
        $factoresIterador = $factores->find()->where(['migranas' => $migranas['id']])->all();

        foreach($factoresIterador as $factores){
            unset($factores['migranas']);
            $factores = $this->desencriptarFactores($factores);
        }

        $migranas['factores'] = $factoresIterador;
        $migranas = $this->desencriptarInforme($migranas);
       
        $this->response->statusCode(200);
        $this->response->type('json');
        $json = json_encode($migranas);
        $this->response->body($json);
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

    public function getCubierto($id = null)
    {
    
        $this->autoRender = false;
        $cubierto['cubierto'] = false;

        $fecha = FrozenTime::now();
        
        $fecha =  $fecha->i18nFormat('YYYY-MM-dd');

        $informes = $this->Migranas->find()->where(['fecha LIKE' => '%'.$fecha.'%'])->where(['ficha' => $id])->all();
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
        $migranas = $this->Migranas->newEntity();
        $migranas = $this->Migranas->patchEntity($migranas, $data);
        $result = $this->Migranas->save($migranas);
        if($result){
            $migranas['id'] = $result->id;
            $this->response->statusCode(200);
            $this->response->type('json');
            $json = json_encode($migranas);
            $this->response->body($json);
        }else{
            header('Access-Control-Allow-Origin: *');
            $this->response->statusCode(500);
            header('Content-Type: application/json');
            $this->set('problema', 'Error al crear la consulta');    
            $this->set('_serialize', ['problema']); 
        } 
    }

    public function desencriptarInforme($migranas){
        $migranas['frecuencia'] = Security::decrypt(base64_decode($migranas['frecuencia']), Security::salt());
        $migranas['duracion'] = Security::decrypt(base64_decode($migranas['duracion']), Security::salt());
        $migranas['horario'] = Security::decrypt(base64_decode($migranas['horario']), Security::salt());
        $migranas['finalizacion'] = Security::decrypt(base64_decode($migranas['finalizacion']), Security::salt());
        $migranas['tipoEpisodio'] = Security::decrypt(base64_decode($migranas['tipoEpisodio']), Security::salt());
        $migranas['intensidad'] = Security::decrypt(base64_decode($migranas['intensidad']), Security::salt());
        $migranas['limitaciones'] = Security::decrypt(base64_decode($migranas['limitaciones']), Security::salt());
        $migranas['despiertoNoche'] = Security::decrypt(base64_decode($migranas['despiertoNoche']), Security::salt());
        $migranas['estadoGeneral'] = Security::decrypt(base64_decode($migranas['estadoGeneral']), Security::salt());

        return $migranas;
    }

    public function desencriptarSintomas($sintomas){
        $sintomas['sintomas'] = Security::decrypt(base64_decode($sintomas['sintomas']), Security::salt());

        return $sintomas;
    }

    public function desencriptarFactores($factores){
        $factores['factores'] = Security::decrypt(base64_decode($factores['factores']), Security::salt());

        return $factores;
    }
}
