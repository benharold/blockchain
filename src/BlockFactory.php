<?php namespace BenHarold\Blockchain;

class BlockFactory
{
    static public $difficulty = 5;

    static function mine(string $data = '') : Block
    {
        $block = new Block(0, $data, '0');
        while (true) {
            if (self::hash_starts_with_n_zeros($block, self::$difficulty)) {
                return $block;
            } else {
                $block->nonce++;
                $block->hash = $block->hash();
            }
        }
    }

    static function hash_starts_with_n_zeros(Block $block, int $n)
    {
        for ($x = 0; $x < $n; $x++) {
            if ($block->hash[$x] !== '0') {
                return false;
            }
        }

        return true;
    }
}
