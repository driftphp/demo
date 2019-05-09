<?php

namespace App\Redis;

use Clue\React\Redis\Client;

/**
 * Class RedisWrapper.
 */
class RedisWrapper
{
    /**
     * @var RedisFactory
     *
     * Redis Factory
     */
    private $redisFactory;

    /**
     * @var RedisConfig
     *
     * Redis config
     */
    private $redisConfig;

    /**
     * RedisWrapper constructor.
     *
     * @param RedisFactory $redisFactory
     * @param RedisConfig  $redisConfig
     */
    public function __construct(
        RedisFactory $redisFactory,
        RedisConfig $redisConfig
    ) {
        $this->redisFactory = $redisFactory;
        $this->redisConfig = $redisConfig;
    }

    /**
     * Get client.
     *
     * @return Client
     */
    public function getClient(): Client
    {
        return $this
            ->redisFactory
            ->create($this->redisConfig);
    }
}
