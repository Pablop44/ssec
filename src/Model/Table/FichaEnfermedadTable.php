<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * FichaEnfermedad Model
 *
 * @method \App\Model\Entity\FichaEnfermedad get($primaryKey, $options = [])
 * @method \App\Model\Entity\FichaEnfermedad newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\FichaEnfermedad[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\FichaEnfermedad|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\FichaEnfermedad saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\FichaEnfermedad patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\FichaEnfermedad[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\FichaEnfermedad findOrCreate($search, callable $callback = null, $options = [])
 */
class FichaEnfermedadTable extends Table
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

        $this->setTable('ficha_enfermedad');
        $this->setDisplayField('ficha');
        $this->setPrimaryKey(['ficha', 'enfermedad']);
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
            ->integer('ficha')
            ->allowEmptyString('ficha', null, 'create');

        $validator
            ->scalar('enfermedad')
            ->maxLength('enfermedad', 50)
            ->allowEmptyString('enfermedad', null, 'create');

        return $validator;
    }
}
