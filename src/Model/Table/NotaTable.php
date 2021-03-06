<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Utility\Security;
use Cake\Event\Event;

/**
 * Nota Model
 *
 * @method \App\Model\Entity\Notum get($primaryKey, $options = [])
 * @method \App\Model\Entity\Notum newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Notum[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Notum|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Notum saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Notum patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Notum[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Notum findOrCreate($search, callable $callback = null, $options = [])
 */
class NotaTable extends Table
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

        $this->setTable('nota');
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
            ->scalar('datos')
            ->maxLength('datos', 511)
            ->requirePresence('datos', 'create')
            ->notEmptyString('datos');

        $validator
            ->integer('ficha')
            ->requirePresence('ficha', 'create')
            ->notEmptyString('ficha');

        return $validator;
    }

    public function beforeSave($event, $entity, $options = array()) {
        $encrypted = Security::encrypt($entity['datos'], Security::salt());
        $entity['datos'] = base64_encode($encrypted);
        return true;
    }
}
