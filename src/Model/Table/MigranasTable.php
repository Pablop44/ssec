<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Utility\Security;
use Cake\Event\Event;

/**
 * Migranas Model
 *
 * @method \App\Model\Entity\Migrana get($primaryKey, $options = [])
 * @method \App\Model\Entity\Migrana newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Migrana[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Migrana|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Migrana saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Migrana patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Migrana[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Migrana findOrCreate($search, callable $callback = null, $options = [])
 */
class MigranasTable extends Table
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

        $this->setTable('migranas');
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
            ->scalar('fecha')
            ->requirePresence('fecha', 'create')
            ->notEmptyString('fecha');

        $validator
            ->integer('ficha')
            ->requirePresence('ficha', 'create')
            ->notEmptyString('ficha');

        $validator
            ->scalar('frecuencia')
            ->requirePresence('frecuencia', 'create')
            ->notEmptyString('frecuencia');

        $validator
            ->scalar('duracion')
            ->requirePresence('duracion', 'create')
            ->notEmptyString('duracion');

        $validator
            ->scalar('horario')
            ->requirePresence('horario', 'create')
            ->notEmptyString('horario');

        $validator
            ->scalar('finalizacion')
            ->requirePresence('finalizacion', 'create')
            ->notEmptyString('finalizacion');

        $validator
            ->scalar('tipoEpisodio')
            ->requirePresence('tipoEpisodio', 'create')
            ->notEmptyString('tipoEpisodio');

        $validator
            ->scalar('intensidad')
            ->requirePresence('intensidad', 'create')
            ->notEmptyString('intensidad');

        $validator
            ->scalar('limitaciones')
            ->requirePresence('limitaciones', 'create')
            ->notEmptyString('limitaciones');

        $validator
            ->scalar('despiertoNoche')
            ->requirePresence('despiertoNoche', 'create')
            ->notEmptyString('despiertoNoche');

        $validator
            ->scalar('estadoGeneral')
            ->maxLength('estadoGeneral', 256)
            ->requirePresence('estadoGeneral', 'create')
            ->notEmptyString('estadoGeneral');

        return $validator;
    }

    public function beforeSave($event, $entity, $options = array()) {
        $encrypted = Security::encrypt($entity['frecuencia'], Security::salt());
        $entity['frecuencia'] = base64_encode($encrypted);
        $encrypted = Security::encrypt($entity['duracion'], Security::salt());
        $entity['duracion'] = base64_encode($encrypted);
        $encrypted = Security::encrypt($entity['horario'], Security::salt());
        $entity['horario'] = base64_encode($encrypted);
        $encrypted = Security::encrypt($entity['finalizacion'], Security::salt());
        $entity['finalizacion'] = base64_encode($encrypted);
        $encrypted = Security::encrypt($entity['tipoEpisodio'], Security::salt());
        $entity['tipoEpisodio'] = base64_encode($encrypted);
        $encrypted = Security::encrypt($entity['intensidad'], Security::salt());
        $entity['intensidad'] = base64_encode($encrypted);
        $encrypted = Security::encrypt($entity['limitaciones'], Security::salt());
        $entity['limitaciones'] = base64_encode($encrypted);
        $encrypted = Security::encrypt($entity['despiertoNoche'], Security::salt());
        $entity['despiertoNoche'] = base64_encode($encrypted);
        $encrypted = Security::encrypt($entity['estadoGeneral'], Security::salt());
        $entity['estadoGeneral'] = base64_encode($encrypted);
        return true;
    }
}
