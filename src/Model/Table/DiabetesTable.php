<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Diabetes Model
 *
 * @method \App\Model\Entity\Diabetes get($primaryKey, $options = [])
 * @method \App\Model\Entity\Diabetes newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Diabetes[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Diabetes|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Diabetes saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Diabetes patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Diabetes[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Diabetes findOrCreate($search, callable $callback = null, $options = [])
 */
class DiabetesTable extends Table
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

        $this->setTable('diabetes');
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
            ->date('fecha')
            ->requirePresence('fecha', 'create')
            ->notEmptyDate('fecha');

        $validator
            ->integer('ficha')
            ->requirePresence('ficha', 'create')
            ->notEmptyString('ficha');

        $validator
            ->integer('numeroControles')
            ->requirePresence('numeroControles', 'create')
            ->notEmptyString('numeroControles');

        $validator
            ->scalar('nivelBajo')
            ->requirePresence('nivelBajo', 'create')
            ->notEmptyString('nivelBajo');

        $validator
            ->scalar('frecuenciaBajo')
            ->requirePresence('frecuenciaBajo', 'create')
            ->notEmptyString('frecuenciaBajo');

        $validator
            ->scalar('horarioBajo')
            ->requirePresence('horarioBajo', 'create')
            ->notEmptyString('horarioBajo');

        $validator
            ->scalar('perdidaConocimiento')
            ->requirePresence('perdidaConocimiento', 'create')
            ->notEmptyString('perdidaConocimiento');

        $validator
            ->scalar('nivelAlto')
            ->requirePresence('nivelAlto', 'create')
            ->notEmptyString('nivelAlto');

        $validator
            ->scalar('frecuenciaAlto')
            ->requirePresence('frecuenciaAlto', 'create')
            ->notEmptyString('frecuenciaAlto');

        $validator
            ->scalar('horarioAlto')
            ->requirePresence('horarioAlto', 'create')
            ->notEmptyString('horarioAlto');

        $validator
            ->scalar('actividadFisica')
            ->requirePresence('actividadFisica', 'create')
            ->notEmptyString('actividadFisica');

        $validator
            ->scalar('problemaDieta')
            ->requirePresence('problemaDieta', 'create')
            ->notEmptyString('problemaDieta');

        $validator
            ->scalar('estadoGeneral')
            ->maxLength('estadoGeneral', 256)
            ->requirePresence('estadoGeneral', 'create')
            ->notEmptyString('estadoGeneral');

        return $validator;
    }
}
