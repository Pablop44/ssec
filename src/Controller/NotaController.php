<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;
use Cake\I18n\FrozenTime;
use Cake\Event\Event;
use Cake\I18n\Time;

/**
 * Nota Controller
 *
 * @property \App\Model\Table\NotaTable $Nota
 *
 * @method \App\Model\Entity\Notum[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class NotaController extends AppController
{
    public $paginate = [
        'page' => 1,
        'limit' => 10,
        'maxLimit' => 15,
        'fields' => [
            'id', 'fecha', 'datos', 'ficha'
        ],
        'sortWhitelist' => [
            'id', 'fecha', 'datos', 'ficha'
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
        $this->Auth->allow(['notasFicha', 'numeroNotas']);
        $this->loadComponent('Csrf');
        $this->loadComponent('Paginator');
    }

    public function beforeFilter(Event $event) {
        
        $this->eventManager()->off($this->Csrf);
    
    }


    public function notasFicha()
    {

        $this->autoRender = false;
        $data = $this->request->getData();

        $this->paginate['page'] = $data['page']+1;
        $this->paginate['limit'] = $data['limit'];

        $conditions = array('ficha' => $data['idFicha']);
        $nota = $this->Nota->find('all', array('conditions' => $conditions));
        $paginador = $this->paginate($nota);

        foreach($paginador as $nota){
            $fecha = FrozenTime::parse($nota['fecha']);
            $nota->fecha = $fecha;
            
            $nota->fecha =  $nota->fecha->i18nFormat('dd/MM/YYYY HH:mm:ss');
        }

        $this->response->statusCode(200);
        $this->response->type('json');
        $json = json_encode($paginador);
        $this->response->body($json);
    }


    public function numeroNotas()
    {

        $this->autoRender = false;
        $data = $this->request->getData();

        $conditions = array('ficha' => $data['idFicha']);
        $nota = $this->Nota->find('all', array('conditions' => $conditions));
        $i = 0;
        foreach($nota as $nota){
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
     * @param string|null $id Notum id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $notum = $this->Nota->get($id, [
            'contain' => [],
        ]);

        $this->set('notum', $notum);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $notum = $this->Nota->newEntity();
        if ($this->request->is('post')) {
            $notum = $this->Nota->patchEntity($notum, $this->request->getData());
            if ($this->Nota->save($notum)) {
                $this->Flash->success(__('The notum has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The notum could not be saved. Please, try again.'));
        }
        $this->set(compact('notum'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Notum id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $notum = $this->Nota->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $notum = $this->Nota->patchEntity($notum, $this->request->getData());
            if ($this->Nota->save($notum)) {
                $this->Flash->success(__('The notum has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The notum could not be saved. Please, try again.'));
        }
        $this->set(compact('notum'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Notum id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $notum = $this->Nota->get($id);
        if ($this->Nota->delete($notum)) {
            $this->Flash->success(__('The notum has been deleted.'));
        } else {
            $this->Flash->error(__('The notum could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
