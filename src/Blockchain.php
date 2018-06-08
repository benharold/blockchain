<?php

namespace BenHarold\Blockchain;

use ArrayAccess;
use Countable;
use Iterator;

/**
 * A blockchain is a chain of blocks.
 *
 * @package BenHarold\Blockchain
 */
class Blockchain implements ArrayAccess, Countable {

    /**
     * @var array The blocks in this blockchain.
     */
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

        if ($block->index !== $previous_block->index + 1) {
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

    /**
     * What is the height of this blockchain?
     *
     * @link http://php.net/manual/en/countable.count.php
     * @return int The custom count as an integer.
     */
    public function count() : int
    {
        return count($this->blocks);
    }

    /**
     * Whether an offset exists
     *
     * @link http://php.net/manual/en/arrayaccess.offsetexists.php
     * @param mixed $offset
     * @return boolean true on success or false on failure.
     */
    public function offsetExists($offset) : bool
    {
        return isset($this->blocks[$offset]);
    }

    /**
     * Offset to retrieve
     *
     * @link http://php.net/manual/en/arrayaccess.offsetget.php
     * @param mixed $offset
     * @return Block The block corresponding to the offset.
     */
    public function offsetGet($offset) : Block
    {
        return $this->blocks[$offset];
    }

    /**
     * Offset to set
     *
     * @link http://php.net/manual/en/arrayaccess.offsetset.php
     * @param mixed $offset
     * @param mixed $value
     * @return void
     */
    public function offsetSet($offset, $value)
    {
        $this->blocks[$offset] = $value;
    }

    /**
     * Offset to unset
     *
     * @link http://php.net/manual/en/arrayaccess.offsetunset.php
     * @param mixed $offset
     * @return void
     */
    public function offsetUnset($offset)
    {
        unset($this->blocks[$offset]);
    }
}
