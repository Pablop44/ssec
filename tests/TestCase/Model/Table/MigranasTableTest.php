<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\MigranasTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\MigranasTable Test Case
 */
class MigranasTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\MigranasTable
     */
    public $Migranas;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.Migranas',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('Migranas') ? [] : ['className' => MigranasTable::class];
        $this->Migranas = TableRegistry::getTableLocator()->get('Migranas', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Migranas);

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
