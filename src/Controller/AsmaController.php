<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;
use Cake\Event\Event;
use Cake\I18n\FrozenTime;

/**
 * Asma Controller
 *
 * @property \App\Model\Table\AsmaTable $Asma
 *
 * @method \App\Model\Entity\Asma[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class AsmaController extends AppController
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
            'id', 'fecha', 'calidadSueno', 'dificultadRespirar', 'tos',
            'gravedadTos', 'limitaciones', 'silbidos', 'usoMedicacion', 'espirometria',
            'factoresCrisis', 'estadoGeneral'
        ],
        'sortWhitelist' => [
            'id', 'fecha', 'calidadSueno', 'dificultadRespirar', 'tos',
            'gravedadTos', 'limitaciones', 'silbidos', 'usoMedicacion', 'espirometria',
            'factoresCrisis', 'estadoGeneral'
        ]
    ];

    
    public function initialize()
    {
        parent::initialize();
        $this->Auth->allow(['asmaFichas', 'numeroInformesAsma', 'view', 'todosAsmaFichas', 'getCubierto']);
        $this->loadComponent('Csrf');
    }

    public function beforeFilter(Event $event) {
        
        $this->eventManager()->off($this->Csrf);   
    }

    
    public function asmaFichas()
    {
        $this->autoRender = false;
        $data = $this->request->getData();
        $this->paginate['page'] = $data['page']+1;
        $this->paginate['limit'] = $data['limit'];

        $conditions = array('ficha' => $data['id']);

        $asma = $this->Asma->find('all', array('conditions' => $conditions));
        $paginador = $this->paginate($asma);

        foreach($paginador as $asma){

            $fecha = FrozenTime::parse($asma['fecha']);
            $asma->fecha = $fecha;
            
            $asma->fecha =  $asma->fecha->i18nFormat('dd/MM/YYYY HH:mm');

        }
       
        $this->response->statusCode(200);
        $this->response->type('json');
        $json = json_encode($paginador);
        $this->response->body($json);
    }


    public function todosAsmaFichas()
    {
        $this->autoRender = false;
        $data = $this->request->getData();

        $asma = $this->Asma->find()->where(['ficha' => $data['id']])->all();

        foreach($asma as $asmaFicha){

            $fecha = FrozenTime::parse($asmaFicha['fecha']);
            $asmaFicha->fecha = $fecha;
            
            $asmaFicha->fecha =  $asmaFicha->fecha->i18nFormat('dd/MM/YYYY HH:mm');

        }
       
        $this->response->statusCode(200);
        $this->response->type('json');
        $json = json_encode($asma);
        $this->response->body($json);
    }

    public function numeroInformesAsma()
    {

        $this->autoRender = false;
        $data = $this->request->getData();

        $conditions = array('ficha' => $data['id']);

        $asma = $this->Asma->find('all', array('conditions' => $conditions));

        $i = 0;

        foreach($asma as $asma){
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
     * @param string|null $id Asma id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
    
        $this->autoRender = false;
        $asma = $this->Asma->get($id);

        $fecha = FrozenTime::parse($asma['fecha']);
        $asma->fecha = $fecha;
        
        $asma->fecha =  $asma->fecha->i18nFormat('dd/MM/YYYY HH:mm');
       
        $this->response->statusCode(200);
        $this->response->type('json');
        $json = json_encode($asma);
        $this->response->body($json);

    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $asma = $this->Asma->newEntity();
        if ($this->request->is('post')) {
            $asma = $this->Asma->patchEntity($asma, $this->request->getData());
            if ($this->Asma->save($asma)) {
                $this->Flash->success(__('The asma has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The asma could not be saved. Please, try again.'));
        }
        $this->set(compact('asma'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Asma id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $asma = $this->Asma->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $asma = $this->Asma->patchEntity($asma, $this->request->getData());
            if ($this->Asma->save($asma)) {
                $this->Flash->success(__('The asma has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The asma could not be saved. Please, try again.'));
        }
        $this->set(compact('asma'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Asma id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $asma = $this->Asma->get($id);
        if ($this->Asma->delete($asma)) {
            $this->Flash->success(__('The asma has been deleted.'));
        } else {
            $this->Flash->error(__('The asma could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }


    public function getCubierto($id = null)
    {
    
        $this->autoRender = false;
        $cubierto['cubierto'] = false;

        $fecha = FrozenTime::now();
        
        $fecha =  $fecha->i18nFormat('YYYY-MM-dd');

        $informes = $this->Asma->find()->where(['fecha LIKE' => '%'.$fecha.'%'])->where(['ficha' => $id])->all();
        if(sizeof($informes) > 0){
            $cubierto['cubierto'] = true;
        }
       
        $this->response->statusCode(200);
        $this->response->type('json');
        $json = json_encode($cubierto);
        $this->response->body($json);

    }
}
