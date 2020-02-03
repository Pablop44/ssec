<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * TratamientoMedicamento Model
 *
 * @method \App\Model\Entity\TratamientoMedicamento get($primaryKey, $options = [])
 * @method \App\Model\Entity\TratamientoMedicamento newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\TratamientoMedicamento[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\TratamientoMedicamento|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\TratamientoMedicamento saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\TratamientoMedicamento patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\TratamientoMedicamento[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\TratamientoMedicamento findOrCreate($search, callable $callback = null, $options = [])
 */
class TratamientoMedicamentoTable extends Table
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

        $this->setTable('tratamiento_medicamento');
        $this->setDisplayField('medicamento');
        $this->setPrimaryKey(['medicamento', 'tratamiento']);
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
            ->scalar('medicamento')
            ->maxLength('medicamento', 50)
            ->allowEmptyString('medicamento', null, 'create');

        $validator
            ->integer('tratamiento')
            ->allowEmptyString('tratamiento', null, 'create');

        return $validator;
    }
}
