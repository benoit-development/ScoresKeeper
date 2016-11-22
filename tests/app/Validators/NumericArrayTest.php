<?php

use App\Validators\NumericArray;

class NumericArrayTest extends TestCase
{
    /**
     * Instance to test
     * 
     * @var NumericArray
     */
    private $instance;
    
    /**
     * 
     * {@inheritDoc}
     * @see \Illuminate\Foundation\Testing\TestCase::setUp()
     */
    protected function setUp() {
        $this->instance = new NumericArray();
    }
    
    
    /**
     * Correct values
     *
     * @return void
     */
    public function testCorrectValues() {
        $this->assertTrue($this->instance->validate(null, [], null));
        $this->assertTrue($this->instance->validate(null, [5], null));
        $this->assertTrue($this->instance->validate(null, [1, 5, 8, 123, -5], null));
        $this->assertTrue($this->instance->validate(null, ['1', "5", "8", '123', '-5'], null));
    }
    
    /**
     * Incorrect values inside array
     */
    public function testIncorrectValues() {
        $this->assertFalse($this->instance->validate(null, ['a'], null));
        $this->assertFalse($this->instance->validate(null, [true], null));
        $this->assertFalse($this->instance->validate(null, [[5]], null));
        $this->assertFalse($this->instance->validate(null, [new stdClass()], null));
    }
    
    /**
     * Incorrect values witch are not arrays
     */
    public function testIncorrectFormatValues() {
        $this->assertFalse($this->instance->validate(null, 'a', null));
        $this->assertFalse($this->instance->validate(null, true, null));
        $this->assertFalse($this->instance->validate(null, 5, null));
        $this->assertFalse($this->instance->validate(null, new stdClass(), null));
    }
    
    /**
     * Unset object instance tested
     * 
     * {@inheritDoc}
     * @see \Illuminate\Foundation\Testing\TestCase::tearDown()
     */
    protected function tearDown() {
        unset($this->instance);
    }
}
