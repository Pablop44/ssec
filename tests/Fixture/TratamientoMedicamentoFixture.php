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
        'medicamento' => ['type' => 'string', 'length' => 50, 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'tratamiento' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        '_indexes' => [
            'fkTratamiento_idx' => ['type' => 'index', 'columns' => ['tratamiento'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['medicamento', 'tratamiento'], 'length' => []],
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
                'medicamento' => '6373fb1a-1ebd-43f0-bbab-da012ec2d6d1',
                'tratamiento' => 1,
            ],
        ];
        parent::init();
    }
}
