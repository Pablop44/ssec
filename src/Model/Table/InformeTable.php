<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Informe Model
 *
 * @method \App\Model\Entity\Informe get($primaryKey, $options = [])
 * @method \App\Model\Entity\Informe newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Informe[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Informe|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Informe saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Informe patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Informe[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Informe findOrCreate($search, callable $callback = null, $options = [])
 */
class InformeTable extends Table
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

        $this->setTable('informe');
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
            ->dateTime('fecha')
            ->requirePresence('fecha', 'create')
            ->notEmptyDateTime('fecha');

        $validator
            ->integer('plantilla')
            ->requirePresence('plantilla', 'create')
            ->notEmptyString('plantilla');

        $validator
            ->integer('ficha')
            ->requirePresence('ficha', 'create')
            ->notEmptyString('ficha');

        return $validator;
    }
}
