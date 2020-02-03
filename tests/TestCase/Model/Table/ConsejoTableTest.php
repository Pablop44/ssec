<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ConsejoTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ConsejoTable Test Case
 */
class ConsejoTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\ConsejoTable
     */
    public $Consejo;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.Consejo',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('Consejo') ? [] : ['className' => ConsejoTable::class];
        $this->Consejo = TableRegistry::getTableLocator()->get('Consejo', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Consejo);

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
