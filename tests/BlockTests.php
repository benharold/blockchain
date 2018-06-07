<?php

use BenHarold\Blockchain\Block;
use PHPUnit\Framework\TestCase;

class BlockTests extends TestCase
{
    function testCreateGenesisBlock()
    {
        $data = 'Chancellor on the brink...';
        $block = new Block(0, $data, '0');
        $expected_hash = hash('sha256', '0' . $block->timestamp->format(\DateTime::ATOM) . '0' . $data);
        $this->assertEquals($expected_hash, $block->hash);
    }

    function testCreateSubsequentBlock()
    {
        $genesis_block = new Block(0, 'Moon', '0');
        $block = $genesis_block->next('Lambo');
        $expected_hash = hash('sha256', '1' . $block->timestamp->format(\DateTime::ATOM) . $genesis_block->hash . 'Lambo');
        $this->assertEquals($expected_hash, $block->hash);
    }
}
