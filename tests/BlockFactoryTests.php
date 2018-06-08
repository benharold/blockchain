<?php

use BenHarold\Blockchain\Block;
use BenHarold\Blockchain\BlockFactory;
use PHPUnit\Framework\TestCase;

class BlockFactoryTests extends TestCase
{
    function testProofOfWork()
    {
        $block = BlockFactory::mine('HODL!');
        var_dump($block);
        $this->assertInstanceOf(Block::class, $block);
    }
}
