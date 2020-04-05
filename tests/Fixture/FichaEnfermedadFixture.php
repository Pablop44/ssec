<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * FichaEnfermedadFixture
 */
class FichaEnfermedadFixture extends TestFixture
{
    /**
     * Table name
     *
     * @var string
     */
    public $table = 'ficha_enfermedad';
    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'ficha' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'enfermedad' => ['type' => 'string', 'length' => 50, 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        '_indexes' => [
            'fkEnfermedad_idx' => ['type' => 'index', 'columns' => ['enfermedad'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['ficha', 'enfermedad'], 'length' => []],
            'fkEnfermedad' => ['type' => 'foreign', 'columns' => ['enfermedad'], 'references' => ['enfermedad', 'nombre'], 'update' => 'cascade', 'delete' => 'cascade', 'length' => []],
            'fkFicha' => ['type' => 'foreign', 'columns' => ['ficha'], 'references' => ['ficha', 'id'], 'update' => 'cascade', 'delete' => 'cascade', 'length' => []],
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
                'ficha' => 1,
                'enfermedad' => '668ffbcb-53fa-4389-9b1f-082abd2347a3',
            ],
        ];
        parent::init();
    }
}
