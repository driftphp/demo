<?php

/*
 * This file is part of the DriftPHP Project
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
use Domain\KeyNotFoundException;
use Domain\ValueRepository;
use React\Promise\PromiseInterface;

/**
 * Class RedisValueRepository.
 */
final class RedisValueRepository implements ValueRepository
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
     * @var array
     */
    private $localValues = [];

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
     * Get value given a key.
     *
     * @param string $key
     *
     * @return string
     *
     * @throws KeyNotFoundException
     */
    public function get(string $key): string
    {
        if (!array_key_exists($key, $this->localValues)) {
            throw new KeyNotFoundException(sprintf('Key % does not exist', $key));
        }

        return $this->localValues[$key];
    }

    /**
     * Get all keys and values.
     *
     * @return array
     */
    public function getAll(): array
    {
        return $this->localValues;
    }

    /**
     * Set value given a key and a value.
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
     * Delete value given a key.
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

    /**
     * Load locally.
     *
     * @return PromiseInterface
     */
    public function loadAll(): PromiseInterface
    {
        return $this
            ->client
            ->hgetall(self::HASH)
            ->then(function (array $values) {
                $this->localValues = array_combine(
                    array_filter($values, function (int $key) {
                        return 0 === $key % 2;
                    }, ARRAY_FILTER_USE_KEY),
                    array_filter($values, function (int $key) {
                        return 1 === $key % 2;
                    }, ARRAY_FILTER_USE_KEY)
                );
            });
    }
}
