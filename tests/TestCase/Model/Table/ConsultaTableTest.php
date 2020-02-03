<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ConsultaTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ConsultaTable Test Case
 */
class ConsultaTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\ConsultaTable
     */
    public $Consulta;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.Consulta',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('Consulta') ? [] : ['className' => ConsultaTable::class];
        $this->Consulta = TableRegistry::getTableLocator()->get('Consulta', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Consulta);

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
