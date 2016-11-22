<?php

use App\Validators\PlayerListSameTournament;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use App\User;
use App\Tournament;
use App\Player;

class PlayerListSameTournamentTest extends TestCase
{
    use DatabaseMigrations;
    
    /**
     * Instance to test
     * 
     * @var PlayerListSameTournament
     */
    private $instance;

    private $p1Id;
    private $p2Id;
    private $p3Id;
    
    /**
     * 
     * {@inheritDoc}
     * @see \Illuminate\Foundation\Testing\TestCase::setUp()
     */
    protected function setUp() {
        parent::setUp();
        
        // jeu de données de la base
        $userId = User::insertGetId([
            'name' => 'test name',
            'email' => 'test@laravel.com',
            'password' => '1234567890',
            'lang' => 'fr',
        ]);
        $t1Id = Tournament::insertGetId([
            'user_id' => $userId,
            'label' => 't1',
            'type_id' => 1,
        ]);
        $t2Id = Tournament::insertGetId([
            'user_id' => $userId,
            'label' => 't2',
            'type_id' => 1,
        ]);
        $this->p1Id = Player::insertGetId(['tournament_id' => $t1Id, 'name' => 'p1']);
        $this->p2Id = Player::insertGetId(['tournament_id' => $t1Id, 'name' => 'p2']);
        $this->p3Id = Player::insertGetId(['tournament_id' => $t2Id, 'name' => 'p2']);
        
        // instance à tester
        $this->instance = new PlayerListSameTournament();
        
    }
        
    /**
     * Correct values witch are not arrays
     */
    public function testCorrectFormatValues() {
        $this->assertTrue($this->instance->validate(null, [$this->p1Id], null));
        $this->assertTrue($this->instance->validate(null, [$this->p1Id, $this->p2Id], null));
        $this->assertTrue($this->instance->validate(null, [$this->p3Id], null));
    }
        
    /**
     * Incorrect values witch are not arrays
     */
    public function testIncorrectFormatValues() {
        $this->assertFalse($this->instance->validate(null, [], null));
        $this->assertFalse($this->instance->validate(null, [$this->p1Id, $this->p3Id], null));
    }
    
    /**
     * Unset object instance tested
     * 
     * {@inheritDoc}
     * @see \Illuminate\Foundation\Testing\TestCase::tearDown()
     */
    protected function tearDown() {
        parent::tearDown();
        unset($this->instance);
    }
}
