<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;
use Cake\Event\Event;
use Cake\I18n\FrozenTime;

/**
 * FichaEnfermedad Controller
 *
 * @property \App\Model\Table\FichaEnfermedadTable $FichaEnfermedad
 *
 * @method \App\Model\Entity\FichaEnfermedad[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class FichaEnfermedadController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */

    public function initialize()
    {
        parent::initialize();
        $this->Auth->allow(['anadirEnfermedad', 'eliminarEnfermedad']);
        $this->loadComponent('Csrf');
    }

    public function beforeFilter(Event $event) {
        
            $this->eventManager()->off($this->Csrf);   
    }


    public function index()
    {
        $fichaEnfermedad = $this->paginate($this->FichaEnfermedad);

        $this->set(compact('fichaEnfermedad'));
    }

    /**
     * View method
     *
     * @param string|null $id Ficha Enfermedad id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $fichaEnfermedad = $this->FichaEnfermedad->get($id, [
            'contain' => [],
        ]);

        $this->set('fichaEnfermedad', $fichaEnfermedad);
    }

    /*
    permite añadir una enfermedad a la ficha del paciente
    */
    public function anadirEnfermedad()
    {
        $this->autoRender = false;
        $fichaEnfermedad = $this->FichaEnfermedad->newEntity();
        $fichaEnfermedad = $this->FichaEnfermedad->patchEntity($fichaEnfermedad, $this->request->getData());
        $this->FichaEnfermedad->save($fichaEnfermedad);
        $this->response->statusCode(200);
        $this->response->type('json');
        $json = json_encode($fichaEnfermedad);
        $this->response->body($json);
    }

    /*
    elimina una enfermedad de la ficha del paciente
    */
    public function eliminarEnfermedad()
    {
        $this->autoRender = false;
        $data = $this->request->getData();
        $fichaEnfermedad = $this->FichaEnfermedad->get([$data['ficha'], $data['enfermedad']]);
        if ($this->FichaEnfermedad->delete($fichaEnfermedad)) {
            $this->response->statusCode(200);
            $this->response->type('json');
            $json = json_encode($fichaEnfermedad);
            $this->response->body($json);
        } else {
            $this->response->statusCode(500);
            $this->response->type('json');
            $json = json_encode($fichaEnfermedad);
            $this->response->body($json);
        }
    }
}
