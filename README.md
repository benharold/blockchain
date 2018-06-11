# A simple blockchain implemented in PHP

In my quest to better understand the fundamental concepts of Bitcoin I've
created this simple blockchain implementation in PHP.

It's not really useful for anything besides playing around with the general
concepts of:

- [Blocks](src/Block.php)
- [Blockchains](src/Blockchain.php)
- [Proof of work mining](src/Mine.php)

The blockchain is stored in an in-memory PHP object. There is no networking
capability as of now.

The proof-of-work system is a simplified version of what is found in Bitcoin.
The difficulty, which is set in the `Mine`, is the number of zeros that
a block hash must begin with in order to be considered valid. It uses
a single pass of SHA-256 unlike Bitcoin's double-SHA-256.

## See Also

- [A blockchain in 200 lines of code by Lauri Hartikka](https://medium.com/@lhartikk/a-blockchain-in-200-lines-of-code-963cc1cc0e54)
- [blockchain-cli](https://github.com/seanjameshan/blockchain-cli)

## Usage

I assume you have [composer](https://getcomposer.org/) installed globally.

1. Clone this repo: `git clone git@github.com:benharold/blockchain.git`
2. Go to the directory where you cloned this repo: `cd blockchain`
3. Install dependencies: `composer install`

That's it. You're ready to go.

## Example

The easiest way to play around with this code is to fire up `psysh`:

    vendor/bin/psysh
    use BenHarold\Blockchain\Mine;
    use BenHarold\Blockchain\Blockchain;

    // Create the genesis block
    $genesis_block_data = 'Chancellor on the brink...';
    $genesis_block = Mine::genesis_block($genesis_block_data);
    
    // Create a new blockchain
    $chain = new Blockchain($genesis_block);
    
    // Add a block
    $block = $chain->extend('HODL!');
    
    var_dump($chain);

Will output something like:

    class BenHarold\Blockchain\Blockchain#1773 (1) {
      protected $blocks =>
      array(2) {
        [0] =>
        class BenHarold\Blockchain\Block#1774 (7) {
          public $index =>
          int(0)
          public $timestamp =>
          class DateTime#1772 (3) {
            ...
          }
          public $data =>
          string(26) "Chancellor on the brink..."
          public $previous_hash =>
          string(1) "0"
          public $nonce =>
          int(2629549)
          public $hash =>
          string(64) "000005ecce6df76aa68cda23ed9ee491418113a12999a9704dee117c8d255a17"
          private $timestamp_format =>
          string(13) "Y-m-d\TH:i:sP"
        }
        [1] =>
        class BenHarold\Blockchain\Block#1777 (7) {
          public $index =>
          int(1)
          public $timestamp =>
          class DateTime#1763 (3) {
            ...
          }
          public $data =>
          string(5) "HODL!"
          public $previous_hash =>
          string(64) "000005ecce6df76aa68cda23ed9ee491418113a12999a9704dee117c8d255a17"
          public $nonce =>
          int(20391)
          public $hash =>
          string(64) "0000063d372a9020803ebd0652c76698b724271c4e3b59cd155c2b1f2c53c4b5"
          private $timestamp_format =>
          string(13) "Y-m-d\TH:i:sP"
        }
      }
    }

## Testing

Tests are written for phpunit, which is a dev dependency:

`vendor/bin/phpunit`

## Code Coverage

The [code coverage report](http://htmlpreview.github.io/?https://github.com/benharold/blockchain/blob/master/docs/coverage/index.html)
can be found in the `docs/coverage` directory. It can be regenerated as follows:

`vendor/bin/phpunit --coverage-html docs/coverage`

## Api Documentation

The [API documentation](http://htmlpreview.github.io/?https://github.com/benharold/blockchain/blob/master/docs/api/index.html)
can be found in the `docs/api` directory. It can be regenerated as follows:

`vendor/bin/apigen generate src --destination docs/api`

## License

[MIT](LICENSE.md)
