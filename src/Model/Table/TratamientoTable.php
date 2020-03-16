<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Tratamiento Model
 *
 * @property \App\Model\Table\MedicamentoTable&\Cake\ORM\Association\BelongsToMany $Medicamento
 *
 * @method \App\Model\Entity\Tratamiento get($primaryKey, $options = [])
 * @method \App\Model\Entity\Tratamiento newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Tratamiento[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Tratamiento|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Tratamiento saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Tratamiento patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Tratamiento[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Tratamiento findOrCreate($search, callable $callback = null, $options = [])
 */
class TratamientoTable extends Table
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

        $this->setTable('tratamiento');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsToMany('Medicamento', [
            'foreignKey' => 'tratamiento_id',
            'targetForeignKey' => 'medicamento_id',
            'joinTable' => 'tratamiento_medicamento',
        ]);
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
            ->scalar('posologia')
            ->maxLength('posologia', 255)
            ->requirePresence('posologia', 'create')
            ->notEmptyString('posologia');

        $validator
            ->date('fechaInicio')
            ->requirePresence('fechaInicio', 'create')
            ->notEmptyDate('fechaInicio');

        $validator
            ->date('fechaFin')
            ->requirePresence('fechaFin', 'create')
            ->notEmptyDate('fechaFin');

        $validator
            ->time('horario')
            ->requirePresence('horario', 'create')
            ->notEmptyTime('horario');

        $validator
            ->scalar('enfermedad')
            ->maxLength('enfermedad', 50)
            ->requirePresence('enfermedad', 'create')
            ->notEmptyString('enfermedad');

        $validator
            ->integer('ficha')
            ->requirePresence('ficha', 'create')
            ->notEmptyString('ficha');

        return $validator;
    }
}
