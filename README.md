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

## Example

    // Create a new blockchain
    $genesis_block_data = 'Chancellor on the brink...';
    $chain = Mine::genesis_block($genesis_block_data);
    
    // Add a block
    $block = $chain[0]->next('HODL!');
    $chain->append($block);
    
    print_r($chain);
    
Will output something like:

    BenHarold\Blockchain\Blockchain Object
    (
        [blocks:protected] => Array
            (
                [0] => BenHarold\Blockchain\Block Object
                    (
                        [index] => 0
                        [timestamp] => DateTime Object
                            (
                                [date] => 2018-06-08 00:57:04.450515
                                [timezone_type] => 3
                                [timezone] => UTC
                            )
    
                        [data] => Chancellor on the brink...
                        [previous_hash] => 0
                        [hash] => ca6acc5eb9c0d935db906895fe78032310e2c71bb7c0ea53b74558b5bbe54479
                        [timestamp_format:BenHarold\Blockchain\Block:private] => Y-m-d\TH:i:sP
                    )
    
                [1] => BenHarold\Blockchain\Block Object
                    (
                        [index] => 1
                        [timestamp] => DateTime Object
                            (
                                [date] => 2018-06-08 00:57:04.450536
                                [timezone_type] => 3
                                [timezone] => UTC
                            )
    
                        [data] => HODL!
                        [previous_hash] => ca6acc5eb9c0d935db906895fe78032310e2c71bb7c0ea53b74558b5bbe54479
                        [hash] => 269d5bafcf07e9c75e20f49a38a123d61aa6f653b9015727c98523d74a950217
                        [timestamp_format:BenHarold\Blockchain\Block:private] => Y-m-d\TH:i:sP
                    )
    
            )
    
    )

## Testing

`vendor/bin/phpunit`

## Code Coverage

The [code coverage report](docs/coverage/index.html) can be found in the `docs/coverage` directory. It can be regenerated as follows:

`vendor/bin/phpunit --coverage-html docs/coverage`

## Api Documentation

The [API documentation](docs/api/index.html) can be found in the `docs/api` directory. It can be regenerated as follows:

`vendor/bin/apigen generate src --destination docs/api`

## License

[MIT](LICENSE.md)
