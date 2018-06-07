<?php

use PHPUnit\Framework\TestCase;
use BenHarold\Blockchain\Block;

class BlockTest extends TestCase
{
    function testCreateBlock()
    {
        $block = new Block(0, new DateTime(),"", "", "");
        var_dump($block);

    }
}
