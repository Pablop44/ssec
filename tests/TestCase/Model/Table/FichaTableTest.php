<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\FichaTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\FichaTable Test Case
 */
class FichaTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\FichaTable
     */
    public $Ficha;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.Ficha',
        'app.Enfermedad',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('Ficha') ? [] : ['className' => FichaTable::class];
        $this->Ficha = TableRegistry::getTableLocator()->get('Ficha', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Ficha);

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
