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

use Domain\ValueRepository;
use React\Promise\PromiseInterface;

/**
 * Class RedisValueRepository
 */
class RedisValueRepository implements ValueRepository
{
    /**
     * @var RedisWrapper
     *
     * Redis Wrapper
     */
    private $redisWrapper;

    /**
     * PutValueController constructor.
     *
     * @param RedisWrapper $redisWrapper
     */
    public function __construct(RedisWrapper $redisWrapper)
    {
        $this->redisWrapper = $redisWrapper;
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
            ->redisWrapper
            ->getClient()
            ->set($key, $value);
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
            ->redisWrapper
            ->getClient()
            ->get($key);
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
            ->redisWrapper
            ->getClient()
            ->del($key);
    }
}