<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Factores Model
 *
 * @method \App\Model\Entity\Factore get($primaryKey, $options = [])
 * @method \App\Model\Entity\Factore newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Factore[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Factore|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Factore saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Factore patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Factore[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Factore findOrCreate($search, callable $callback = null, $options = [])
 */
class FactoresTable extends Table
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

        $this->setTable('factores');
        $this->setDisplayField('migranas');
        $this->setPrimaryKey(['migranas', 'factores']);
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
            ->integer('migranas')
            ->allowEmptyString('migranas', null, 'create');

        $validator
            ->scalar('factores')
            ->allowEmptyString('factores', null, 'create');

        return $validator;
    }
}
