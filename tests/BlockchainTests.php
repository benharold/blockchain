<?php

use BenHarold\Blockchain\Block;
use BenHarold\Blockchain\Blockchain;
use PHPUnit\Framework\TestCase;

class BlockchainTests extends TestCase
{
    public $chain;

    public $genesis_block;

    public $next_block;

    function setUp()
    {
        $this->chain = new Blockchain('HODL!');
        $this->genesis_block = $this->chain->block(0);
        $this->next_block = $this->genesis_block->next('This is gentlemen');
    }

    function testFetchGenesisBlockFromBlockchain()
    {
        $this->assertInstanceOf(Block::class, $this->genesis_block);
    }

    function testValidateBadIndex()
    {
        $block = $this->next_block;
        $block->index = 2;
        $this->assertFalse($this->chain->validate_new_block($block));
    }

    function testValidateBadPreviousHash()
    {
        $block = $this->next_block;
        $block->previous_hash = 'nonsense';
        $this->assertFalse($this->chain->validate_new_block($block));
    }

    function testValidateBadHash()
    {
        $block = $this->next_block;
        $block->hash = 'nonsense';
        $this->assertFalse($this->chain->validate_new_block($block));
    }

    function testValidateGoodBlock()
    {
        $block = $this->next_block;
        $this->assertTrue($this->chain->validate_new_block($block));
    }

    /**
     * @expectedException BenHarold\Blockchain\InvalidBlockException
     */
    function testAppendBadBlock()
    {
        $block = $this->next_block;
        $block->hash = 'nonsense';
        $this->chain->append($block);
    }

    function testAppendGoodBlock()
    {
        $block = $this->next_block;
        $this->chain->append($block);
        $this->assertEquals(1, $this->chain->block($block->index)->index);
    }

    function testBlockchainIsCountable()
    {
        $this->assertEquals(1, count($this->chain));
    }

    function testArrayAccess()
    {
        $this->assertTrue(isset($this->chain[0]));
        $this->assertEquals(0, $this->chain[0]->index);
        unset($this->chain[0]);
        $this->assertFalse(isset($this->chain[0]));
        $this->chain[0] = new Block(0, 'Faketoshi was here', '0');
        $this->assertTrue(isset($this->chain[0]));
    }
    function testBalls()
    {
        $chain = new Blockchain('Chancellor on the brink...');
        $next_block = $chain[0]->next('HODL!');
        $chain->append($next_block);
        print_r($chain);
    }
}
