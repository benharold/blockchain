<?php

namespace BenHarold\Blockchain;

/**
 * A blockchain is a chain of blocks.
 *
 * @package BenHarold\Blockchain
 */
class Blockchain {

    protected $blocks = [];

    /**
     * Create a brand new blockchain.
     *
     * @param string $genesis_block_data
     */
    public function __construct(string $genesis_block_data)
    {
        $this->blocks[] = new Block(0, $genesis_block_data, $previous_hash = '0');
    }

    /**
     * Get a block from the blockchain according to it's index.
     *
     * @param int $index
     * @return \BenHarold\Blockchain\Block
     */
    function block(int $index) : Block
    {
        return $this->blocks[$index];
    }

    /**
     * Append a valid block to the blockchain.
     *
     * @param \BenHarold\Blockchain\Block $block
     * @throws \BenHarold\Blockchain\InvalidBlockException
     */
    function append(Block $block) {
        if ( ! $this->validate_new_block($block)) {
            throw new InvalidBlockException();
        }

        $this->blocks[] = $block;
    }

    /**
     * Determine if a new block is a valid extension of the current blockchain.
     *
     * @param \BenHarold\Blockchain\Block $block
     * @return bool
     */
    function validate_new_block(Block $block) : bool
    {
        $previous_block = end($this->blocks);

        if ($block->index !== ++$previous_block->index) {
            return FALSE;
        }

        if ($block->previous_hash != $previous_block->hash) {
            return FALSE;
        }

        if ($block->hash != $block->hash()) {
            return FALSE;
        }

        return TRUE;
    }

}
