<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Enfermedad Model
 *
 * @property \App\Model\Table\FichaTable&\Cake\ORM\Association\BelongsToMany $Ficha
 *
 * @method \App\Model\Entity\Enfermedad get($primaryKey, $options = [])
 * @method \App\Model\Entity\Enfermedad newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Enfermedad[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Enfermedad|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Enfermedad saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Enfermedad patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Enfermedad[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Enfermedad findOrCreate($search, callable $callback = null, $options = [])
 */
class EnfermedadTable extends Table
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

        $this->setTable('enfermedad');
        $this->setDisplayField('nombre');
        $this->setPrimaryKey('nombre');

        $this->belongsToMany('Ficha', [
            'foreignKey' => 'enfermedad_id',
            'targetForeignKey' => 'ficha_id',
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
            ->scalar('nombre')
            ->maxLength('nombre', 50)
            ->allowEmptyString('nombre', null, 'create');

        return $validator;
    }
}
