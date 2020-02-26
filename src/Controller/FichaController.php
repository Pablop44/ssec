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

    public function initialize()
    {
        parent::initialize();
        $this->Auth->allow(['fichas', 'view']);
        $this->loadComponent('Csrf');
    }

    public function beforeFilter(Event $event) {
        
            $this->eventManager()->off($this->Csrf);   
    }

    public function fichas()
    {
        $this->autoRender = false;
        $fichas = $this->Ficha->find()->all();

        foreach($fichas as $ficha){
            
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
        $json = json_encode($fichas);
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

    /**
     * Delete method
     *
     * @param string|null $id Ficha id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $ficha = $this->Ficha->get($id);
        if ($this->Ficha->delete($ficha)) {
            $this->Flash->success(__('The ficha has been deleted.'));
        } else {
            $this->Flash->error(__('The ficha could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
