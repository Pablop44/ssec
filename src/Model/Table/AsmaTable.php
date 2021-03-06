<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Utility\Security;
use Cake\Event\Event;

/**
 * Asma Model
 *
 * @method \App\Model\Entity\Asma get($primaryKey, $options = [])
 * @method \App\Model\Entity\Asma newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Asma[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Asma|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Asma saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Asma patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Asma[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Asma findOrCreate($search, callable $callback = null, $options = [])
 */
class AsmaTable extends Table
{
    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->setTable('asma');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {
        $validator
            ->integer('id')
            ->allowEmptyString('id', null, 'create');

        $validator
            ->scalar('fecha')
            ->requirePresence('fecha', 'create')
            ->notEmptyString('fecha');

        $validator
            ->integer('ficha')
            ->requirePresence('ficha', 'create')
            ->notEmptyString('ficha');

        $validator
            ->scalar('calidadSueno')
            ->requirePresence('calidadSueno', 'create')
            ->notEmptyString('calidadSueno');

        $validator
            ->scalar('dificultadRespirar')
            ->requirePresence('dificultadRespirar', 'create')
            ->notEmptyString('dificultadRespirar');

        $validator
            ->scalar('tos')
            ->requirePresence('tos', 'create')
            ->notEmptyString('tos');

        $validator
            ->scalar('gravedadTos')
            ->requirePresence('gravedadTos', 'create')
            ->notEmptyString('gravedadTos');

        $validator
            ->scalar('limitaciones')
            ->requirePresence('limitaciones', 'create')
            ->notEmptyString('limitaciones');

        $validator
            ->scalar('silbidos')
            ->requirePresence('silbidos', 'create')
            ->notEmptyString('silbidos');

        $validator
            ->scalar('usoMedicacion')
            ->requirePresence('usoMedicacion', 'create')
            ->notEmptyString('usoMedicacion');

        $validator
            ->scalar('espirometria')
            ->maxLength('espirometria', 256)
            ->requirePresence('espirometria', 'create')
            ->notEmptyString('espirometria');

        $validator
            ->scalar('factoresCrisis')
            ->maxLength('factoresCrisis', 256)
            ->requirePresence('factoresCrisis', 'create')
            ->notEmptyString('factoresCrisis');

        $validator
            ->scalar('estadoGeneral')
            ->maxLength('estadoGeneral', 256)
            ->requirePresence('estadoGeneral', 'create')
            ->notEmptyString('estadoGeneral');

        return $validator;
    }

    public function beforeSave($event, $entity, $options = array()) {
        $encrypted = Security::encrypt($entity['calidadSueno'], Security::salt());
        $entity['calidadSueno'] = base64_encode($encrypted);
        $encrypted = Security::encrypt($entity['dificultadRespirar'], Security::salt());
        $entity['dificultadRespirar'] = base64_encode($encrypted);
        $encrypted = Security::encrypt($entity['tos'], Security::salt());
        $entity['tos'] = base64_encode($encrypted);
        $encrypted = Security::encrypt($entity['gravedadTos'], Security::salt());
        $entity['gravedadTos'] = base64_encode($encrypted);
        $encrypted = Security::encrypt($entity['limitaciones'], Security::salt());
        $entity['limitaciones'] = base64_encode($encrypted);
        $encrypted = Security::encrypt($entity['silbidos'], Security::salt());
        $entity['silbidos'] = base64_encode($encrypted);
        $encrypted = Security::encrypt($entity['usoMedicacion'], Security::salt());
        $entity['usoMedicacion'] = base64_encode($encrypted);
        $encrypted = Security::encrypt($entity['espirometria'], Security::salt());
        $entity['espirometria'] = base64_encode($encrypted);
        $encrypted = Security::encrypt($entity['factoresCrisis'], Security::salt());
        $entity['factoresCrisis'] = base64_encode($encrypted);
        $encrypted = Security::encrypt($entity['estadoGeneral'], Security::salt());
        $entity['estadoGeneral'] = base64_encode($encrypted);
        return true;
    }
}
