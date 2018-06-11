<?php

use BenHarold\Blockchain\Mine;
use PHPUnit\Framework\TestCase;

class MineTests extends TestCase
{
    function testProofOfWork()
    {
        Mine::$difficulty = 3;
        $block = Mine::genesis_block('HODL!');
        $this->assertEquals('000', substr($block->hash, 0, 3));
    }
}
