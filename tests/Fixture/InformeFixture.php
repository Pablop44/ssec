<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * InformeFixture
 */
class InformeFixture extends TestFixture
{
    /**
     * Table name
     *
     * @var string
     */
    public $table = 'informe';
    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'fecha' => ['type' => 'datetime', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'plantilla' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'ficha' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        '_indexes' => [
            'fkPlantilla_idx' => ['type' => 'index', 'columns' => ['plantilla'], 'length' => []],
            'fkFicha_idx' => ['type' => 'index', 'columns' => ['ficha'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'fkFichaInforme' => ['type' => 'foreign', 'columns' => ['ficha'], 'references' => ['ficha', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
            'fkPlantillaInforme' => ['type' => 'foreign', 'columns' => ['plantilla'], 'references' => ['plantilla', 'id'], 'update' => 'cascade', 'delete' => 'cascade', 'length' => []],
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
                'fecha' => '2020-02-03 12:05:42',
                'plantilla' => 1,
                'ficha' => 1,
            ],
        ];
        parent::init();
    }
}
