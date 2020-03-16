<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\TratamientoTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\TratamientoTable Test Case
 */
class TratamientoTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\TratamientoTable
     */
    public $Tratamiento;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.Tratamiento',
        'app.Medicamento',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('Tratamiento') ? [] : ['className' => TratamientoTable::class];
        $this->Tratamiento = TableRegistry::getTableLocator()->get('Tratamiento', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Tratamiento);

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
