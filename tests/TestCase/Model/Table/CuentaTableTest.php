<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\CuentaTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\CuentaTable Test Case
 */
class CuentaTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\CuentaTable
     */
    public $Cuenta;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.Cuenta',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('Cuenta') ? [] : ['className' => CuentaTable::class];
        $this->Cuenta = TableRegistry::getTableLocator()->get('Cuenta', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Cuenta);

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
