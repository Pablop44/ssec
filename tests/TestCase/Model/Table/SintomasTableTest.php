<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\SintomasTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\SintomasTable Test Case
 */
class SintomasTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\SintomasTable
     */
    public $Sintomas;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.Sintomas',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('Sintomas') ? [] : ['className' => SintomasTable::class];
        $this->Sintomas = TableRegistry::getTableLocator()->get('Sintomas', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Sintomas);

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
