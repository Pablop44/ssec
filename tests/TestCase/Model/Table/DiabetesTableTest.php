<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\DiabetesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\DiabetesTable Test Case
 */
class DiabetesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\DiabetesTable
     */
    public $Diabetes;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.Diabetes',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('Diabetes') ? [] : ['className' => DiabetesTable::class];
        $this->Diabetes = TableRegistry::getTableLocator()->get('Diabetes', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Diabetes);

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
