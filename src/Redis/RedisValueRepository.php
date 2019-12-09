<?php

/*
 * This file is part of the DriftPHP Demo
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * Feel free to edit as you please, and have fun.
 *
 * @author Marc Morera <yuhu@mmoreram.com>
 */

declare(strict_types=1);

namespace Infrastructure\Redis;

use Clue\React\Redis\Client;
use Domain\ValueRepository;
use React\Promise\PromiseInterface;

/**
 * Class RedisValueRepository
 */
class RedisValueRepository implements ValueRepository
{
    /**
     * @var Client
     *
     * Redis Client
     */
    private $client;

    /**
     * @var string
     *
     * Prefix
     */
    private const HASH = 'demo';

    /**
     * PutValueController constructor.
     *
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * Set value given a key and a value
     *
     * @param string $key
     * @param string $value
     *
     * @return PromiseInterface
     */
    public function set(string $key, string $value): PromiseInterface
    {
        return $this
            ->client
            ->hset(self::HASH, $key, $value);
    }

    /**
     * Get value given a key
     *
     * @param string $key
     *
     * @return PromiseInterface
     */
    public function get(string $key): PromiseInterface
    {
        return $this
            ->client
            ->hget(self::HASH, $key);
    }

    /**
     * Get all keys and values
     *
     * @return PromiseInterface
     */
    public function getAll() : PromiseInterface
    {
        return $this
            ->client
            ->hgetall(self::HASH)
            ->then(function(array $values) {

                return array_combine(
                    array_filter($values, function(int $key) {
                        return $key % 2 === 0;
                    }, ARRAY_FILTER_USE_KEY),
                    array_filter($values, function(int $key) {
                        return $key % 2 === 1;
                    }, ARRAY_FILTER_USE_KEY)
                );
            });
    }

    /**
     * Delete value given a key
     *
     * @param string $key
     *
     * @return PromiseInterface
     */
    public function delete(string $key): PromiseInterface
    {
        return $this
            ->client
            ->hdel(self::HASH, $key);
    }
}