<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Ficha Model
 *
 * @property \App\Model\Table\EnfermedadTable&\Cake\ORM\Association\BelongsToMany $Enfermedad
 *
 * @method \App\Model\Entity\Ficha get($primaryKey, $options = [])
 * @method \App\Model\Entity\Ficha newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Ficha[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Ficha|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Ficha saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Ficha patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Ficha[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Ficha findOrCreate($search, callable $callback = null, $options = [])
 */
class FichaTable extends Table
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

        $this->setTable('ficha');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsToMany('Enfermedad', [
            'foreignKey' => 'ficha',
            'targetForeignKey' => 'enfermedad',
            'joinTable' => 'ficha_enfermedad',
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
            ->dateTime('fechaCreacion')
            ->requirePresence('fechaCreacion', 'create')
            ->notEmptyDateTime('fechaCreacion');

        $validator
            ->integer('paciente')
            ->requirePresence('paciente', 'create')
            ->notEmptyString('paciente');

        $validator
            ->integer('medico')
            ->requirePresence('medico', 'create')
            ->notEmptyString('medico');

        return $validator;
    }
}
