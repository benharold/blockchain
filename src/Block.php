<?php

namespace BenHarold\Blockchain;

/**
 * A block is a timestamped, indexed chunk of data suitable for inclusion in a
 * blockchain.
 *
 * @package BenHarold\Blockchain
 */
class Block {

    /**
     * @var int The index of this block in the blockchain.
     */
    public $index;

    /**
     * @var \DateTime The timestamp when this block was created.
     */
    public $timestamp;

    /**
     * @var string Arbitrary data to be stored in the blockchain.
     */
    public $data;

    /**
     * @var string The SHA-256 hash of the previous block in the blockchain.
     */
    public $previous_hash;

    /**
     * @var string The SHA-256 hash of the string representation of this block.
     */
    public $hash;

    /**
     * @var string The string format that we use for the timestamp.
     */
    private $timestamp_format = \DateTime::ATOM;

    /**
     * Create a new block.
     *
     * @param int $index
     * @param string $data
     * @param string $previous_hash
     */
    function __construct(int $index, string $data, string $previous_hash) {
        $this->index = $index;
        $this->timestamp = new \DateTime();
        $this->data = $data;
        $this->previous_hash = $previous_hash;
        $this->hash = $this->hash();
    }

    /**
     * Hash this block.
     *
     * @return string The SHA-256 hash of the string representation of this block.
     */
    function hash()
    {
        return hash('sha256', (string) $this->index . $this->timestamp->format($this->timestamp_format) . $this->previous_hash . $this->data);
    }

    /**
     * Create a new block for the blockchain using this block as the tip of the
     * chain.
     *
     * @param string $data
     * @return \BenHarold\Blockchain\Block
     */
    function next(string $data)
    {
        $previous_hash = $this->hash;
        $next_index = $this->index + 1;

        return new Block($next_index, $data, $previous_hash);
    }

}
