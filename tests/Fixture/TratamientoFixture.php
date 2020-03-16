<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * TratamientoFixture
 */
class TratamientoFixture extends TestFixture
{
    /**
     * Table name
     *
     * @var string
     */
    public $table = 'tratamiento';
    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'posologia' => ['type' => 'string', 'length' => 255, 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'fechaInicio' => ['type' => 'date', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'fechaFin' => ['type' => 'date', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'horario' => ['type' => 'time', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'enfermedad' => ['type' => 'string', 'length' => 50, 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'ficha' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        '_indexes' => [
            'fkEnfermedad_idx' => ['type' => 'index', 'columns' => ['enfermedad'], 'length' => []],
            'fkFicha_idx' => ['type' => 'index', 'columns' => ['ficha'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'fkEnfermedadTratamiento' => ['type' => 'foreign', 'columns' => ['enfermedad'], 'references' => ['enfermedad', 'nombre'], 'update' => 'cascade', 'delete' => 'cascade', 'length' => []],
            'fkFichaTratamiento' => ['type' => 'foreign', 'columns' => ['ficha'], 'references' => ['ficha', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
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
                'posologia' => 'Lorem ipsum dolor sit amet',
                'fechaInicio' => '2020-03-16',
                'fechaFin' => '2020-03-16',
                'horario' => '10:43:48',
                'enfermedad' => 'Lorem ipsum dolor sit amet',
                'ficha' => 1,
            ],
        ];
        parent::init();
    }
}
