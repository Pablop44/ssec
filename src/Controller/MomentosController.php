<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;
use Cake\Event\Event;
use Cake\I18n\FrozenTime;
use Cake\Utility\Security;

/**
 * Momentos Controller
 *
 * @property \App\Model\Table\MomentosTable $Momentos
 *
 * @method \App\Model\Entity\Momento[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class MomentosController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function initialize()
    {
        parent::initialize();
        $this->loadComponent('Csrf');
    }

    public function beforeFilter(Event $event) {
        $this->eventManager()->off($this->Csrf);   
    }

    /*
    Añade momentos para el informe diabetes
    */
    public function add()
    {
        $this->autoRender = false;
        $data = $this->request->getData();
        $momento = $this->Momentos->newEntity();
        $momento = $this->Momentos->patchEntity($momento, $data);
        if($this->Momentos->save($momento)){
            $this->response->statusCode(200);
            $this->response->type('json');
            $json = json_encode($momento);
            $this->response->body($json);
        }else{
            header('Access-Control-Allow-Origin: *');
            $this->response->statusCode(500);
            header('Content-Type: application/json');
            $this->set('problema', 'Error al crear la consulta');    
            $this->set('_serialize', ['problema']); 
        } 
    }
}
