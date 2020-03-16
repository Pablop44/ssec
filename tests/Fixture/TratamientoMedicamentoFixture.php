<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * TratamientoMedicamentoFixture
 */
class TratamientoMedicamentoFixture extends TestFixture
{
    /**
     * Table name
     *
     * @var string
     */
    public $table = 'tratamiento_medicamento';
    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'medicamento' => ['type' => 'string', 'length' => 50, 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'tratamiento' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        '_indexes' => [
            'fkTratamiento_idx' => ['type' => 'index', 'columns' => ['tratamiento'], 'length' => []],
            'fkMedicamento' => ['type' => 'index', 'columns' => ['medicamento'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'fkMedicamento' => ['type' => 'foreign', 'columns' => ['medicamento'], 'references' => ['medicamento', 'nombre'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
            'fkTratamiento' => ['type' => 'foreign', 'columns' => ['tratamiento'], 'references' => ['tratamiento', 'id'], 'update' => 'cascade', 'delete' => 'cascade', 'length' => []],
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
                'medicamento' => 'Lorem ipsum dolor sit amet',
                'tratamiento' => 1,
            ],
        ];
        parent::init();
    }
}
