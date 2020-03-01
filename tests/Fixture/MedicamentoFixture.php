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
        'dosis' => ['type' => 'string', 'length' => 50, 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
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
                'nombre' => 'c0e3a884-e437-4c69-b574-5787f62f8230',
                'viaAdministracion' => 'Lorem ipsum dolor sit amet',
                'marca' => 'Lorem ipsum dolor sit amet',
                'dosis' => 'Lorem ipsum dolor sit amet',
            ],
        ];
        parent::init();
    }
}
