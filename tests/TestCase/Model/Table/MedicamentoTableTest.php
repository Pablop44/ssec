<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\MedicamentoTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\MedicamentoTable Test Case
 */
class MedicamentoTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\MedicamentoTable
     */
    public $Medicamento;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.Medicamento',
        'app.Tratamiento',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('Medicamento') ? [] : ['className' => MedicamentoTable::class];
        $this->Medicamento = TableRegistry::getTableLocator()->get('Medicamento', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Medicamento);

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
