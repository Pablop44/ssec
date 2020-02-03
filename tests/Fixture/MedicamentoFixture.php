<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * MedicamentoFixture
 */
class MedicamentoFixture extends TestFixture
{
    /**
     * Table name
     *
     * @var string
     */
    public $table = 'medicamento';
    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'nombre' => ['type' => 'string', 'length' => 50, 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'viaAdministracion' => ['type' => 'string', 'length' => null, 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'marca' => ['type' => 'string', 'length' => 50, 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        '_indexes' => [
            'fkMarca_idx' => ['type' => 'index', 'columns' => ['marca'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['nombre'], 'length' => []],
            'fkMarcaMedicamento' => ['type' => 'foreign', 'columns' => ['marca'], 'references' => ['marca', 'nombre'], 'update' => 'cascade', 'delete' => 'cascade', 'length' => []],
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
                'nombre' => '5556a88d-f0b5-41fb-b728-a27e68278e3c',
                'viaAdministracion' => 'Lorem ipsum dolor sit amet',
                'marca' => 'Lorem ipsum dolor sit amet',
            ],
        ];
        parent::init();
    }
}
