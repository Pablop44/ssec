<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;
use Cake\Event\Event;
use Cake\I18n\FrozenTime;

/**
 * Sintomas Controller
 *
 * @property \App\Model\Table\SintomasTable $Sintomas
 *
 * @method \App\Model\Entity\Sintoma[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class SintomasController extends AppController
{

    public function initialize()
    {
        parent::initialize();
        $this->loadComponent('Csrf');
    }

    public function beforeFilter(Event $event) {
        $this->eventManager()->off($this->Csrf);   
    }

    /*
    Añade sintomas al informe de migrañas
    */
    public function add()
    {
        $this->autoRender = false;
        $data = $this->request->getData();
        $sintoma = $this->Sintomas->newEntity();
        $sintoma = $this->Sintomas->patchEntity($sintoma, $data);
        if($this->Sintomas->save($sintoma)){
            $this->response->statusCode(200);
            $this->response->type('json');
            $json = json_encode($sintoma);
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
