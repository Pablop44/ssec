<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Medicamento Model
 *
 * @property \App\Model\Table\TratamientoTable&\Cake\ORM\Association\BelongsToMany $Tratamiento
 *
 * @method \App\Model\Entity\Medicamento get($primaryKey, $options = [])
 * @method \App\Model\Entity\Medicamento newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Medicamento[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Medicamento|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Medicamento saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Medicamento patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Medicamento[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Medicamento findOrCreate($search, callable $callback = null, $options = [])
 */
class MedicamentoTable extends Table
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

        $this->setTable('medicamento');
        $this->setDisplayField('nombre');
        $this->setPrimaryKey('nombre');

        $this->belongsToMany('Tratamiento', [
            'foreignKey' => 'medicamento_id',
            'targetForeignKey' => 'tratamiento_id',
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
            ->scalar('nombre')
            ->maxLength('nombre', 50)
            ->allowEmptyString('nombre', null, 'create');

        $validator
            ->scalar('viaAdministracion')
            ->requirePresence('viaAdministracion', 'create')
            ->notEmptyString('viaAdministracion');

        $validator
            ->scalar('marca')
            ->maxLength('marca', 50)
            ->requirePresence('marca', 'create')
            ->notEmptyString('marca');

        $validator
            ->scalar('dosis')
            ->maxLength('dosis', 50)
            ->requirePresence('dosis', 'create')
            ->notEmptyString('dosis');

        return $validator;
    }
}
