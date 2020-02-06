<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Cuenta Model
 *
 * @method \App\Model\Entity\Cuentum get($primaryKey, $options = [])
 * @method \App\Model\Entity\Cuentum newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Cuentum[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Cuentum|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Cuentum saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Cuentum patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Cuentum[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Cuentum findOrCreate($search, callable $callback = null, $options = [])
 */
class CuentaTable extends Table
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

        $this->setTable('cuenta');
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
            ->scalar('rol')
            ->requirePresence('rol', 'create')
            ->notEmptyString('rol');

        $validator
            ->scalar('estado')
            ->requirePresence('estado', 'create')
            ->notEmptyString('estado');

        $validator
            ->integer('user')
            ->requirePresence('user', 'create')
            ->notEmptyString('user');

        return $validator;
    }
}
