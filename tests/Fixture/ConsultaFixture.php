<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * ConsultaFixture
 */
class ConsultaFixture extends TestFixture
{
    /**
     * Table name
     *
     * @var string
     */
    public $table = 'consulta';
    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'lugar' => ['type' => 'string', 'length' => 50, 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'motivo' => ['type' => 'string', 'length' => 255, 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'fecha' => ['type' => 'datetime', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'diagnostico' => ['type' => 'string', 'length' => 511, 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'observaciones' => ['type' => 'string', 'length' => 511, 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'medico' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'paciente' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'ficha' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        '_indexes' => [
            'fkPaciente_idx' => ['type' => 'index', 'columns' => ['paciente'], 'length' => []],
            'fkMedico_idx' => ['type' => 'index', 'columns' => ['medico'], 'length' => []],
            'fkFicha_idx' => ['type' => 'index', 'columns' => ['ficha'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'fkFichaConsulta1' => ['type' => 'foreign', 'columns' => ['ficha'], 'references' => ['ficha', 'id'], 'update' => 'cascade', 'delete' => 'cascade', 'length' => []],
            'fkMedicoConsulta1' => ['type' => 'foreign', 'columns' => ['medico'], 'references' => ['user', 'id'], 'update' => 'cascade', 'delete' => 'cascade', 'length' => []],
            'fkPacienteConsulta1' => ['type' => 'foreign', 'columns' => ['paciente'], 'references' => ['user', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
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
                'lugar' => 'Lorem ipsum dolor sit amet',
                'motivo' => 'Lorem ipsum dolor sit amet',
                'fecha' => '2020-02-03 12:04:46',
                'diagnostico' => 'Lorem ipsum dolor sit amet',
                'observaciones' => 'Lorem ipsum dolor sit amet',
                'medico' => 1,
                'paciente' => 1,
                'ficha' => 1,
            ],
        ];
        parent::init();
    }
}
