<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\TratamientoMedicamentoTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\TratamientoMedicamentoTable Test Case
 */
class TratamientoMedicamentoTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\TratamientoMedicamentoTable
     */
    public $TratamientoMedicamento;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.TratamientoMedicamento',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('TratamientoMedicamento') ? [] : ['className' => TratamientoMedicamentoTable::class];
        $this->TratamientoMedicamento = TableRegistry::getTableLocator()->get('TratamientoMedicamento', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->TratamientoMedicamento);

        parent::tearDown();
    }

    /**
     * Test initialize method
     *
     * @return void
     */
    public function testInitialize()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test validationDefault method
     *
     * @return void
     */
    public function testValidationDefault()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
