<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\FichaEnfermedadTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\FichaEnfermedadTable Test Case
 */
class FichaEnfermedadTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\FichaEnfermedadTable
     */
    public $FichaEnfermedad;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.FichaEnfermedad',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('FichaEnfermedad') ? [] : ['className' => FichaEnfermedadTable::class];
        $this->FichaEnfermedad = TableRegistry::getTableLocator()->get('FichaEnfermedad', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->FichaEnfermedad);

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
