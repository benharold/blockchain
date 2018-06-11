<?php namespace BenHarold\Blockchain;

/**
 * This is a basic blockchain mine which implements a naive proof of work system
 * based on the number of zeros that the block hash begins with.
 *
 * @package BenHarold\Blockchain
 */
class Mine
{
    /**
     * @var int The number of zeros that the block hash must begin with.
     */
    static public $difficulty = 5;

    /**
     * Mine a genesis block for a new blockchain.
     *
     * @param string $data
     * @return \BenHarold\Blockchain\Block
     */
    static function genesis_block(string $data = '') : Block
    {
        $block = new Block(0, $data, '0');
        while (true) {
            if (self::hash_starts_with_n_zeros($block, self::$difficulty)) {
                break;
            } else {
                $block->nonce++;
                $block->hash = $block->hash();
            }
        }

        return $block;
    }

    /**
     * Mine a block that extends a blockchain.
     *
     * @param string $data
     * @param \BenHarold\Blockchain\Block $previous_block
     * @return \BenHarold\Blockchain\Block
     */
    static function block(string $data = '', Block $previous_block) : Block
    {
        $index = $previous_block->index + 1;
        $previous_hash = $previous_block->hash;
        $block = new Block($index, $data, $previous_hash);
        while (true) {
            if (self::hash_starts_with_n_zeros($block, self::$difficulty)) {
                break;
            } else {
                $block->nonce++;
                $block->hash = $block->hash();
            }
        }

        return $block;
    }

    /**
     * Check that a block hash begins with a specific number of zeros.
     *
     * @param \BenHarold\Blockchain\Block $block
     * @param int $n The number of zeros that the block hash must begin with.
     * @return bool
     */
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
