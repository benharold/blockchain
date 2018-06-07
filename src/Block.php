<?php

namespace BenHarold\Blockchain;

class Block {

    protected $index;

    protected $timestamp;

    protected $data;

    protected $hash;

    protected $previous_hash;

    function __construct(int $index, \DateTime $timestamp, string $data, string $hash, string $previous_hash) {
        $this->index = $index;
        $this->timestamp = $timestamp;
        $this->data = $data;
        $this->hash = $hash;
        $this->previous_hash = $previous_hash;
    }

}
