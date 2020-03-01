<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\MarcaTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\MarcaTable Test Case
 */
class MarcaTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\MarcaTable
     */
    public $Marca;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.Marca',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('Marca') ? [] : ['className' => MarcaTable::class];
        $this->Marca = TableRegistry::getTableLocator()->get('Marca', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Marca);

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
