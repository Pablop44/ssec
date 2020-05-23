<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\InformeTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\InformeTable Test Case
 */
class InformeTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\InformeTable
     */
    public $Informe;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.Informe',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Informe);

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
