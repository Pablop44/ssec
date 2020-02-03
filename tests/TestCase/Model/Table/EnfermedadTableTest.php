<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\EnfermedadTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\EnfermedadTable Test Case
 */
class EnfermedadTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\EnfermedadTable
     */
    public $Enfermedad;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.Enfermedad',
        'app.Ficha',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('Enfermedad') ? [] : ['className' => EnfermedadTable::class];
        $this->Enfermedad = TableRegistry::getTableLocator()->get('Enfermedad', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Enfermedad);

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
