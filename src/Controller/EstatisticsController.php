<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;
use Cake\I18n\FrozenTime;
use Cake\Event\Event;
use Cake\I18n\Time;
use Cake\Utility\Security;
use Firebase\JWT\JWT;

/**
 * Estatistics Controller
 *
 *
 * @method \App\Model\Entity\Estatistic[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class EstatisticsController extends AppController
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
        $this->Auth->allow(['estadisticasMedicamentosMasUtilizados']);
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

        if(($action == "estadisticasUsuario" || $action == "estadisticasEnfermedades"  || $action == "estadisticasEnfermedadesPorSexo" 
        || $action == "estadisticasEnfermedadesPorEdad" || $action == "estadisticasMedicamentosMasUtilizados") && $rol == "administrador"){
            return true;    
        }else{
            return false;
        }
    }

    /*
    Devuelve las estadísticas de los roles de usuarios del sistema
    Solo accesible por el administrador
    */
    public function estadisticasUsuario()
    {
        $check = $this->checkToken();
        if($check){
            $this->autoRender = false;
            $cuentas = TableRegistry::getTableLocator()->get('Cuenta');
            $iteradorUsuarioMedicos = $cuentas->find()->where(['rol' => 'medico'])->all();
            $iteradorUsuarioPacientes = $cuentas->find()->where(['rol' => 'paciente'])->all();
            $iteradorUsuarioAdministradores = $cuentas->find()->where(['rol' => 'administrador'])->all();

            $array = array();
            $array['medicos'] = sizeof($iteradorUsuarioMedicos);
            $array['administradores'] = sizeof($iteradorUsuarioAdministradores);
            $array['pacientes'] = sizeof($iteradorUsuarioPacientes);

            $this->response->statusCode(200);
            $this->response->type('json');
            $json = json_encode($array);
            $this->response->body($json);
        }else{
            $this->response->statusCode(403);
            $this->response->type('json');
            $json = json_encode("error");
            $this->response->body($json);
        }
    }

    /*
    Devuelve las estadísticas de los casos de enfermedades del sistema
    Solo accesible por el administrador
    */
    public function estadisticasEnfermedades()
    {
        $check = $this->checkToken();
        if($check){
            $this->autoRender = false;
            $enfermedades = TableRegistry::getTableLocator()->get('FichaEnfermedad');
            $iteradorEnfermedadAsma = $enfermedades->find()->where(['enfermedad' => 'asma'])->all();
            $iteradorEnfermedadMigranas = $enfermedades->find()->where(['enfermedad' => 'migranas'])->all();
            $iteradorEnfermedadDiabetes = $enfermedades->find()->where(['enfermedad' => 'diabetes'])->all();

            $array = array();
            $array['asma'] = sizeof($iteradorEnfermedadAsma);
            $array['migranas'] = sizeof($iteradorEnfermedadMigranas);
            $array['diabetes'] = sizeof($iteradorEnfermedadDiabetes);

            $this->response->statusCode(200);
            $this->response->type('json');
            $json = json_encode($array);
            $this->response->body($json);
        }else{
            $this->response->statusCode(403);
            $this->response->type('json');
            $json = json_encode("error");
            $this->response->body($json);
        }
    }

    /*
    Devuelve las estadísticas de los casos de enfermedades del sistema por sexo
    Solo accesible por el administrador
    */
    public function estadisticasEnfermedadesPorSexo()
    {
        $check = $this->checkToken();
        if($check){
            $this->autoRender = false;
            $enfermedades = TableRegistry::getTableLocator()->get('FichaEnfermedad');
            $iteradorEnfermedadAsma = $enfermedades->find()->where(['enfermedad' => 'asma'])->all();
            $ficha = TableRegistry::getTableLocator()->get('Ficha');
            $user = TableRegistry::getTableLocator()->get('User');
            $masculinoAsma = 0;
            $femeninoAsma = 0;
            foreach($iteradorEnfermedadAsma as $iterador){
                $iteradorFicha = $ficha->find()->where(['id' => $iterador['ficha']])->all();
                foreach($iteradorFicha as $iterador2){
                    $iteradorUser = $user->find()->where(['id' => $iterador2['paciente']])->all();
                    foreach($iteradorUser as $iterador3){
                        if($iterador3['genero'] == "Male"){
                            $masculinoAsma++;
                        }else{
                            $femeninoAsma++; 
                        }
                    }
                }
            }
            $masculinoMigranas = 0;
            $femeninoMigranas = 0;
            $iteradorEnfermedadMigranas = $enfermedades->find()->where(['enfermedad' => 'migranas'])->all();
            foreach($iteradorEnfermedadMigranas as $iterador){
                $iteradorFicha = $ficha->find()->where(['id' => $iterador['ficha']])->all();
                foreach($iteradorFicha as $iterador2){
                    $iteradorUser = $user->find()->where(['id' => $iterador2['paciente']])->all();
                    foreach($iteradorUser as $iterador3){
                        if($iterador3['genero'] == "Male"){
                            $masculinoMigranas++;
                        }else{
                            $femeninoMigranas++; 
                        }
                    }
                }
            }

            $masculinoDiabetes = 0;
            $femeninoDiabetes = 0;
            $iteradorEnfermedadDiabetes = $enfermedades->find()->where(['enfermedad' => 'diabetes'])->all();
            foreach($iteradorEnfermedadDiabetes as $iterador){
                $iteradorFicha = $ficha->find()->where(['id' => $iterador['ficha']])->all();
                foreach($iteradorFicha as $iterador2){
                    $iteradorUser = $user->find()->where(['id' => $iterador2['paciente']])->all();
                    foreach($iteradorUser as $iterador3){
                        if($iterador3['genero'] == "Male"){
                            $masculinoDiabetes++;
                        }else{
                            $femeninoDiabetes++; 
                        }
                    }
                }
            }

            $array = array();
            $array['masculinoAsma'] = $masculinoAsma;
            $array['femeninoAsma'] = $femeninoAsma;

            $array['masculinoMigranas'] = $masculinoMigranas;
            $array['femeninoMigranas'] = $femeninoMigranas;

            $array['masculinoDiabetes'] = $masculinoDiabetes;
            $array['femeninoDiabetes'] = $femeninoDiabetes;

            $this->response->statusCode(200);
            $this->response->type('json');
            $json = json_encode($array);
            $this->response->body($json);
        }else{
            $this->response->statusCode(403);
            $this->response->type('json');
            $json = json_encode("error");
            $this->response->body($json);
        }
    }


    /*
    Devuelve las estadísticas de los casos de enfermedades del sistema por sexo
    Solo accesible por el administrador
    */
    public function estadisticasEnfermedadesPorEdad()
    {
        $check = $this->checkToken();
        if($check){
            $this->autoRender = false;
            $enfermedades = TableRegistry::getTableLocator()->get('FichaEnfermedad');
            $iteradorEnfermedadAsma = $enfermedades->find()->where(['enfermedad' => 'asma'])->all();
            $ficha = TableRegistry::getTableLocator()->get('Ficha');
            $user = TableRegistry::getTableLocator()->get('User');
            $menores20Asma = 0;
            $menores40Asma = 0;
            $menores60Asma = 0;
            $menores80Asma = 0;
            $menores100Asma = 0;
            foreach($iteradorEnfermedadAsma as $iterador){
                $iteradorFicha = $ficha->find()->where(['id' => $iterador['ficha']])->all();
                foreach($iteradorFicha as $iterador2){
                    $iteradorUser = $user->find()->where(['id' => $iterador2['paciente']])->all();
                    foreach($iteradorUser as $iterador3){
                        $fecha = FrozenTime::parse($iterador3->nacimiento);
                        $time = FrozenTime::now();
                        $diff = $time->diff($fecha);
                        if((int)$diff->y < 20){
                            $menores20Asma++;
                        }else if((int)$diff->y < 40){
                            $menores40Asma++;
                        }else if((int)$diff->y < 60){
                            $menores60Asma++;
                        }else if((int)$diff->y < 80){
                            $menores80Asma++;
                        }else{
                            $menores100Asma++;
                        }
                    }
                }
            }

            
            $menores20Migranas = 0;
            $menores40Migranas = 0;
            $menores60Migranas = 0;
            $menores80Migranas = 0;
            $menores100Migranas = 0;
            $iteradorEnfermedadMigranas = $enfermedades->find()->where(['enfermedad' => 'migranas'])->all();
            foreach($iteradorEnfermedadMigranas as $iterador){
                $iteradorFicha = $ficha->find()->where(['id' => $iterador['ficha']])->all();
                foreach($iteradorFicha as $iterador2){
                    $iteradorUser = $user->find()->where(['id' => $iterador2['paciente']])->all();
                    foreach($iteradorUser as $iterador3){
                        $fecha = FrozenTime::parse($iterador3->nacimiento);
                        $time = FrozenTime::now();
                        $diff = $time->diff($fecha);
                        if((int)$diff->y < 20){
                            $menores20Migranas++;
                        }else if((int)$diff->y < 40){
                            $menores40Migranas++;
                        }else if((int)$diff->y < 60){
                            $menores60Migranas++;
                        }else if((int)$diff->y < 80){
                            $menores80Migranas++;
                        }else{
                            $menores100Migranas++;
                        }
                    }
                }
            }

            $menores20Diabetes = 0;
            $menores40Diabetes = 0;
            $menores60Diabetes = 0;
            $menores80Diabetes = 0;
            $menores100Diabetes = 0;
            $iteradorEnfermedadDiabetes = $enfermedades->find()->where(['enfermedad' => 'diabetes'])->all();
            foreach($iteradorEnfermedadDiabetes as $iterador){
                $iteradorFicha = $ficha->find()->where(['id' => $iterador['ficha']])->all();
                foreach($iteradorFicha as $iterador2){
                    $iteradorUser = $user->find()->where(['id' => $iterador2['paciente']])->all();
                    foreach($iteradorUser as $iterador3){
                        $fecha = FrozenTime::parse($iterador3->nacimiento);
                        $time = FrozenTime::now();
                        $diff = $time->diff($fecha);
                        if((int)$diff->y < 20){
                            $menores20Diabetes++;
                        }else if((int)$diff->y < 40){
                            $menores40Diabetes++;
                        }else if((int)$diff->y < 60){
                            $menores60Diabetes++;
                        }else if((int)$diff->y < 80){
                            $menores80Diabetes++;
                        }else{
                            $menores100Diabetes++;
                        }
                    }
                }
            }

            $array = array();
            $array['menores20Asma'] = $menores20Asma;
            $array['menores40Asma'] = $menores40Asma;
            $array['menores60Asma'] = $menores60Asma;
            $array['menores80Asma'] = $menores80Asma;
            $array['menores100Asma'] = $menores100Asma;
            $array['menores20Migranas'] = $menores20Migranas;
            $array['menores40Migranas'] = $menores40Migranas;
            $array['menores60Migranas'] = $menores60Migranas;
            $array['menores80Migranas'] = $menores80Migranas;
            $array['menores100Migranas'] = $menores100Migranas;
            $array['menores20Diabetes'] = $menores20Diabetes;
            $array['menores40Diabetes'] = $menores40Diabetes;
            $array['menores60Diabetes'] = $menores60Diabetes;
            $array['menores80Diabetes'] = $menores80Diabetes;
            $array['menores100Diabetes'] = $menores100Diabetes;

            $this->response->statusCode(200);
            $this->response->type('json');
            $json = json_encode($array);
            $this->response->body($json);
        }else{
            $this->response->statusCode(403);
            $this->response->type('json');
            $json = json_encode("error");
            $this->response->body($json);
        }
    }

    /*
    Devuelve las estadísticas de medicamentos más utilizados en los tratamientos
    Solo accesible por el administrador
    */
    public function estadisticasMedicamentosMasUtilizados()
    {
        $check = $this->checkToken();
        if($check){
            $this->autoRender = false;
            $medicamentos = TableRegistry::getTableLocator()->get('Medicamento');
            $medicamentoTratamientos = TableRegistry::getTableLocator()->get('TratamientoMedicamento');
            $iteradorMedicamento = $medicamentos->find()->all();

            $array = array();

            foreach($iteradorMedicamento as $iterador){
                $i = 0;
                $iteradorMedicamentoTratamiento = $medicamentoTratamientos->find()->where(['medicamento' => $iterador['nombre']])->all();
                foreach($iteradorMedicamentoTratamiento as $iterador2){
                    $i++;
                }
                $array[$iterador['nombre']] = $i;
            }

            $arrayAEnviar = array();
            for ($i = 0; $i < 5; $i++){
                $value = max($array);
                $key = array_search($value, $array);
                unset($array[$key]);
                $arrayAEnviar[$key] = $value;
            }

            $this->response->statusCode(200);
            $this->response->type('json');
            $json = json_encode($arrayAEnviar);
            $this->response->body($json);
        }else{
            $this->response->statusCode(403);
            $this->response->type('json');
            $json = json_encode("error");
            $this->response->body($json);
        }
    }
}
