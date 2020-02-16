<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Consulta Model
 *
 * @method \App\Model\Entity\Consultum get($primaryKey, $options = [])
 * @method \App\Model\Entity\Consultum newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Consultum[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Consultum|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Consultum saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Consultum patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Consultum[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Consultum findOrCreate($search, callable $callback = null, $options = [])
 */
class ConsultaTable extends Table
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

        $this->setTable('consulta');
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
            ->scalar('lugar')
            ->maxLength('lugar', 50)
            ->requirePresence('lugar', 'create')
            ->notEmptyString('lugar');

        $validator
            ->scalar('motivo')
            ->maxLength('motivo', 255)
            ->requirePresence('motivo', 'create')
            ->notEmptyString('motivo');

        $validator
            ->date('fecha')
            ->requirePresence('fecha', 'create')
            ->notEmptyDate('fecha');

        $validator
            ->scalar('diagnostico')
            ->maxLength('diagnostico', 511)
            ->allowEmptyString('diagnostico');

        $validator
            ->scalar('observaciones')
            ->maxLength('observaciones', 511)
            ->allowEmptyString('observaciones');

        $validator
            ->integer('medico')
            ->requirePresence('medico', 'create')
            ->notEmptyString('medico');

        $validator
            ->integer('paciente')
            ->requirePresence('paciente', 'create')
            ->notEmptyString('paciente');

        $validator
            ->integer('ficha')
            ->requirePresence('ficha', 'create')
            ->notEmptyString('ficha');

        $validator
            ->scalar('estado')
            ->requirePresence('estado', 'create')
            ->notEmptyString('estado');

        return $validator;
    }
}
