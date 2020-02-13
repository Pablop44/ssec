<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * FichaFixture
 */
class FichaFixture extends TestFixture
{
    /**
     * Table name
     *
     * @var string
     */
    public $table = 'ficha';
    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'fechaCreacion' => ['type' => 'datetime', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'paciente' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'medico' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        '_indexes' => [
            'fkPaciente_idx' => ['type' => 'index', 'columns' => ['paciente'], 'length' => []],
            'fkMedico_idx' => ['type' => 'index', 'columns' => ['medico'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'fkMedicoFicha' => ['type' => 'foreign', 'columns' => ['medico'], 'references' => ['user', 'id'], 'update' => 'cascade', 'delete' => 'cascade', 'length' => []],
            'fkPacienteFicha' => ['type' => 'foreign', 'columns' => ['paciente'], 'references' => ['user', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
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
                'fechaCreacion' => '2020-02-13 17:39:03',
                'paciente' => 1,
                'medico' => 1,
            ],
        ];
        parent::init();
    }
}
