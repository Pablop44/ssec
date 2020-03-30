<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Sintomas Model
 *
 * @method \App\Model\Entity\Sintoma get($primaryKey, $options = [])
 * @method \App\Model\Entity\Sintoma newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Sintoma[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Sintoma|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Sintoma saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Sintoma patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Sintoma[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Sintoma findOrCreate($search, callable $callback = null, $options = [])
 */
class SintomasTable extends Table
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

        $this->setTable('sintomas');
        $this->setDisplayField('migranas');
        $this->setPrimaryKey(['migranas', 'sintomas']);
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
            ->scalar('sintomas')
            ->allowEmptyString('sintomas', null, 'create');

        return $validator;
    }
}
