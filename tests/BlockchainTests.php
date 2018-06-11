<?php

use BenHarold\Blockchain\Block;
use BenHarold\Blockchain\Blockchain;
use BenHarold\Blockchain\Mine;
use PHPUnit\Framework\TestCase;

class BlockchainTests extends TestCase
{
    public $chain;

    public $genesis_block;

    public $next_block;

    function setUp()
    {
        // Tests will run reasonably quickly with this difficulty level
        Mine::$difficulty = 2;
        $this->genesis_block = Mine::genesis_block('HODL!');
        $this->chain = new Blockchain($this->genesis_block);
        $this->next_block = $this->genesis_block->next('This is gentlemen');
    }

    function testFetchGenesisBlockFromBlockchain()
    {
        $this->assertInstanceOf(Block::class, $this->chain[0]);
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

    function testValidateGoodChain()
    {
        $this->chain->extend('More babies are dying');
        $this->chain->extend('fuck your mother if you want fuck');
        $this->assertTrue($this->chain->validate());
    }

    function testValidateChainWithBadIndex()
    {
        $this->chain->extend('BCash is the real Bitcoin');
        $this->chain[1]->index = 2;
        $this->assertFalse($this->chain->validate());
    }

    function testValidateChainWithBadPreviousHash()
    {
        $this->chain->extend('Craig Wright is Satoshi Nakamoto');
        $this->chain[1]->previous_hash = 'nonsense';
        $this->assertFalse($this->chain->validate());
    }

    function testValidateChainWithBadHash()
    {
        $this->chain->extend('Anything that Roger Ver says');
        $this->chain[1]->hash = 'nonsense';
        $this->assertFalse($this->chain->validate());
    }

    function testLaziness()
    {
        $this->chain->extend('This is gentlemen...');
        $this->assertEquals(2, count($this->chain));
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
}
