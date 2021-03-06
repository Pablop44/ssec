<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;
use Cake\Event\Event;
use Cake\I18n\FrozenTime;
use Cake\Utility\Security;
use Firebase\JWT\JWT;

/**
 * Tratamiento Controller
 *
 * @property \App\Model\Table\TratamientoTable $Tratamiento
 *
 * @method \App\Model\Entity\Tratamiento[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class TratamientoController extends AppController
{
    public $paginate = [
        'page' => 1,
        'limit' => 10,
        'maxLimit' => 15,
        'fields' => [
            'id', 'posologia', 'fechaInicio', 'fechaFin', 'horario', 'enfermedad'
        ],
        'sortWhitelist' => [
            'id', 'posologia', 'fechaInicio', 'fechaFin', 'horario', 'enfermedad'
        ]
    ];

    /*
    Función que inicializa el controlador
    */
    public function initialize()
    {
        parent::initialize();
        $this->loadComponent('Csrf');
        $this->loadComponent('Paginator');
    }

    public function beforeFilter(Event $event) {
        $this->eventManager()->off($this->Csrf); 
    }

    /*
    Función que controla el token del header de autroización y controla el acceso a las funciones restringidas del controlador
    */
    public function checkToken(){
        $this->autoRender = false;
        $token = $this->request->header('Authorization');
        $action = $this->getRequest()->getParam('action');
        $token = str_replace("Bearer ", "",$token);
        $id = JWT::decode(
            $token,
            Security::getSalt(),
            array('HS256')
        );
        $array['id'] = $id;

        $cuenta = TableRegistry::getTableLocator()->get('Cuenta');
        $iteradorCuentas = $cuenta->find()->where(['user' => $array['id']->sub])->all();

        foreach($iteradorCuentas as $iterador){
            $rol = $iterador['rol'];
        }

        if(($action == "tratramientosFicha" || $action == "numeroTratramientosFicha" || $action == "crearTratamiento" || $action == "view" || $action == "delete") && $rol == "administrador"){
            return true;    
        }else if(($action == "tratramientosFicha" || $action == "numeroTratramientosFicha" || $action == "crearTratamiento" || $action == "view" || $action == "delete") && $rol == "medico"){
            return true;
        }else if(($action == "viewPaciente") && $rol == "paciente"){
            return true;
        }else{
            return false;
        }
    }

    /*
    Función que devuelve información de tratamientos de una ficha
    Accesible por el administrador y médico y paciente
    */
    public function tratramientosFicha()
    {
        $this->autoRender = false;
        $data = $this->request->getData();

        $this->paginate['page'] = $data['page']+1;
        $this->paginate['limit'] = $data['limit'];

        if(isset($data['tipo'])){
            $this->paginate['order'] = [$data['tipo'] => 'desc'];
        }

        $conditions = array('ficha' => $data['idFicha']);
    
        $tratamiento = $this->Tratamiento->find('all', array('conditions' => $conditions));
        $paginador = $this->paginate($tratamiento);

        foreach($paginador as $tratamiento){
            $fecha = FrozenTime::parse($tratamiento['fechaInicio']);
            $tratamiento->fechaInicio = $fecha;
            $tratamiento->fechaInicio =  $tratamiento->fechaInicio->i18nFormat('dd/MM/YYYY');

            $fecha2 = FrozenTime::parse($tratamiento['fechaFin']);
            $tratamiento->fechaFin = $fecha2;
            $tratamiento->fechaFin =  $tratamiento->fechaFin->i18nFormat('dd/MM/YYYY');

            $horario = FrozenTime::parse($tratamiento['horario']);
            $tratamiento->horario = $horario;
            $tratamiento->horario =  $tratamiento->horario->i18nFormat('HH:mm');

            $tratamientoMedicamento = TableRegistry::getTableLocator()->get('TratamientoMedicamento');
            $iteradorMedicamentos = $tratamientoMedicamento->find()->where(['tratamiento' => $tratamiento['id']])->all();

            foreach($iteradorMedicamentos as $tratamientoMedicamento1){
                $medicamentos = TableRegistry::getTableLocator()->get('Medicamento');
                $iteradorMedicamentos2 = $medicamentos->find()->where(['nombre' => $tratamientoMedicamento1['medicamento']])->all();
                $tratamiento['medicamentos'] = $iteradorMedicamentos2;
            }

            $tratamiento = $this->desencriptarTratamiento($tratamiento);
        }

        $this->response->statusCode(200);
        $this->response->type('json');
        $json = json_encode($paginador);
        $this->response->body($json);
    }

    /*
    Función que devuelve el número de tratamientos de una ficha
     Accesible por el administrador y médico y paciente
    */
    public function numeroTratramientosFicha()
    {
        $this->autoRender = false;
        $data = $this->request->getData();

        $conditions = array('ficha' => $data['idFicha']);

        $tratamiento = $this->Tratamiento->find('all', array('conditions' => $conditions));
        $paginador = $this->paginate($tratamiento);

        $i = 0;

        foreach($paginador as $tratamiento){
            $i++;
        }

        $obj = array();
        $obj['numero'] = $i;

        $this->response->statusCode(200);
        $this->response->type('json');
        $json = json_encode($obj);
        $this->response->body($json);
    }

    /*
    Devuelve la información de un tratamiento
    */
    public function view($id = null)
    {
        $check = $this->checkToken();
        if($check){
            $this->autoRender = false;
            $tratamiento = $this->Tratamiento->get($id,[
                'contain' => ['Medicamento'],
            ]);

            $fecha = FrozenTime::parse($tratamiento['fechaInicio']);
            $tratamiento->fechaInicio = $fecha;
            $tratamiento->fechaInicio =  $tratamiento->fechaInicio->i18nFormat('dd/MM/YYYY');

            $fecha2 = FrozenTime::parse($tratamiento['fechaFin']);
            $tratamiento->fechaFin = $fecha2;
            $tratamiento->fechaFin =  $tratamiento->fechaFin->i18nFormat('dd/MM/YYYY');

            $horario = FrozenTime::parse($tratamiento['horario']);
            $tratamiento->horario = $horario;
            $tratamiento->horario =  $tratamiento->horario->i18nFormat('HH:mm');

            $tratamiento = $this->desencriptarTratamiento($tratamiento);

            $this->response->statusCode(200);
            $this->response->type('json');
            $json = json_encode($tratamiento);
            $this->response->body($json);
        }else{
            $this->response->statusCode(200);
            $this->response->type('json');
            $json = json_encode("error");
            $this->response->body($json);
        }
    }


    public function viewPaciente($id = null)
    {
        $check = $this->checkToken();
        if($check){
            $this->autoRender = false;
            $tratamiento = $this->Tratamiento->get($id);

            $fecha = FrozenTime::parse($tratamiento['fechaInicio']);
            $tratamiento->fechaInicio = $fecha;
            $tratamiento->fechaInicio =  $tratamiento->fechaInicio->i18nFormat('dd/MM/YYYY');

            $fecha2 = FrozenTime::parse($tratamiento['fechaFin']);
            $tratamiento->fechaFin = $fecha2;
            $tratamiento->fechaFin =  $tratamiento->fechaFin->i18nFormat('dd/MM/YYYY');

            $horario = FrozenTime::parse($tratamiento['horario']);
            $tratamiento->horario = $horario;
            $tratamiento->horario =  $tratamiento->horario->i18nFormat('HH:mm');

            $tratamientoMedicamento = TableRegistry::getTableLocator()->get('TratamientoMedicamento');
            $iteradorMedicamentos = $tratamientoMedicamento->find()->where(['tratamiento' => $tratamiento['id']])->all();

            $medicamentosArray = array();

            foreach($iteradorMedicamentos as $tratamientoMedicamento1){
                $medicamentos = TableRegistry::getTableLocator()->get('Medicamento');
                $iteradorMedicamentos2 = $medicamentos->find()->where(['nombre' => $tratamientoMedicamento1['medicamento']])->all();
                array_push($medicamentosArray, $iteradorMedicamentos2->toArray()[0]);
            }

            $tratamiento['medicamentos'] = $medicamentosArray;

            $tratamiento = $this->desencriptarTratamiento($tratamiento);

            $this->response->statusCode(200);
            $this->response->type('json');
            $json = json_encode($tratamiento);
            $this->response->body($json);
        }else{
            $this->response->statusCode(200);
            $this->response->type('json');
            $json = json_encode("error");
            $this->response->body($json);
        }
    }

    /*
    funcion que crea un tratamiento asignado a una ficha determinada
    */
    public function crearTratamiento()
    {
        $check = $this->checkToken();
        if($check){
            $this->autoRender = false;
            $tratamiento = $this->Tratamiento->newEntity();
            $tratamiento = $this->Tratamiento->patchEntity($tratamiento, $this->request->getData());
            $result = $this->Tratamiento->save($tratamiento);
            $tratamientoId['id'] = $result->id;
            $this->response->statusCode(200);
            $this->response->type('json');
            $json = json_encode($tratamientoId);
            $this->response->body($json);
        }else{
            $this->response->statusCode(200);
            $this->response->type('json');
            $json = json_encode("error");
            $this->response->body($json);
        }
    }

    /*
    Función que elimina un tratamiento de una ficha
    */
    public function delete($id = null)
    {
        $check = $this->checkToken();
        if($check){
            $this->autoRender = false;
            $tratamiento = $this->Tratamiento->get($id);
            $this->Tratamiento->delete($tratamiento);
            $this->response->statusCode(200);
            $this->response->type('json');
            $json = json_encode($id);
            $this->response->body($json);
        }else{
            $this->response->statusCode(200);
            $this->response->type('json');
            $json = json_encode("error");
            $this->response->body($json);
        }
    }

    /*
    Función que desencripta la información de un tratamiento
    */
    public function desencriptarTratamiento($tratamiento){
        $tratamiento['posologia'] = Security::decrypt(base64_decode($tratamiento['posologia']), Security::salt());
        return $tratamiento;
    }
}
