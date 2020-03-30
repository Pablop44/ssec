<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\MomentosTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\MomentosTable Test Case
 */
class MomentosTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\MomentosTable
     */
    public $Momentos;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.Momentos',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('Momentos') ? [] : ['className' => MomentosTable::class];
        $this->Momentos = TableRegistry::getTableLocator()->get('Momentos', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Momentos);

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
