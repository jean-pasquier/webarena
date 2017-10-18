<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\FightersTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\FightersTable Test Case
 */
class FightersTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\FightersTable
     */
    public $Fighters;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.fighters'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('Fighters') ? [] : ['className' => FightersTable::class];
        $this->Fighters = TableRegistry::get('Fighters', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Fighters);

        parent::tearDown();
    }

    /**
     * Test getBestFighter method
     *
     * @return void
     */
    public function testGetBestFighter()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
