<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\AsmaTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\AsmaTable Test Case
 */
class AsmaTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\AsmaTable
     */
    public $Asma;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.Asma',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('Asma') ? [] : ['className' => AsmaTable::class];
        $this->Asma = TableRegistry::getTableLocator()->get('Asma', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Asma);

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
