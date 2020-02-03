<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * ConsejoFixture
 */
class ConsejoFixture extends TestFixture
{
    /**
     * Table name
     *
     * @var string
     */
    public $table = 'consejo';
    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'recomendacion' => ['type' => 'string', 'length' => 511, 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'paciente' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'medico' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        '_indexes' => [
            'fkPaciente_idx' => ['type' => 'index', 'columns' => ['paciente'], 'length' => []],
            'fkMedico_idx' => ['type' => 'index', 'columns' => ['medico'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'fkMedicoConsejo' => ['type' => 'foreign', 'columns' => ['medico'], 'references' => ['user', 'id'], 'update' => 'cascade', 'delete' => 'cascade', 'length' => []],
            'fkPacienteConsejo' => ['type' => 'foreign', 'columns' => ['paciente'], 'references' => ['user', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
        ],
        '_options' => [
            'engine' => 'InnoDB',
            'collation' => 'utf8_general_ci'
        ],
    ];
    // @codingStandardsIgnoreEnd
    /**
     * Init method
     *
     * @return void
     */
    public function init()
    {
        $this->records = [
            [
                'id' => 1,
                'recomendacion' => 'Lorem ipsum dolor sit amet',
                'paciente' => 1,
                'medico' => 1,
            ],
        ];
        parent::init();
    }
}
