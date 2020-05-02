<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Utility\Security;
use Cake\Event\Event;

/**
 * Momentos Model
 *
 * @method \App\Model\Entity\Momento get($primaryKey, $options = [])
 * @method \App\Model\Entity\Momento newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Momento[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Momento|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Momento saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Momento patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Momento[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Momento findOrCreate($search, callable $callback = null, $options = [])
 */
class MomentosTable extends Table
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

        $this->setTable('momentos');
        $this->setDisplayField('diabetes');
        $this->setPrimaryKey(['diabetes', 'momento']);
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
            ->integer('diabetes')
            ->allowEmptyString('diabetes', null, 'create');

        $validator
            ->scalar('momento')
            ->allowEmptyString('momento', null, 'create');

        return $validator;
    }

    public function beforeSave($event, $entity, $options = array()) {
        $encrypted = Security::encrypt($entity['momento'], Security::salt());
        $entity['momento'] = base64_encode($encrypted);
        return true;
    }
}
