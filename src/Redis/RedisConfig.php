<?php

/*
 * This file is part of the Apisearch Server
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * Feel free to edit as you please, and have fun.
 *
 * @author Marc Morera <yuhu@mmoreram.com>
 */

declare(strict_types=1);

namespace App\Redis;

/**
 * Class RedisConfig.
 */
class RedisConfig
{
    /**
     * @var string
     *
     * Host
     */
    private $host;

    /**
     * @var int
     *
     * Port
     */
    private $port;

    /**
     * @var string|null
     *
     * Database
     */
    private $database;

    /**
     * RedisConfig constructor.
     *
     * @param string $host
     * @param int    $port
     * @param string $database
     */
    public function __construct(
        string $host,
        int $port,
        string $database = null
    ) {
        $this->host = $host;
        $this->port = $port;
        $this->database = $database;
    }

    /**
     * Get Host.
     *
     * @return string
     */
    public function getHost(): string
    {
        return $this->host;
    }

    /**
     * Get Port.
     *
     * @return int
     */
    public function getPort(): int
    {
        return $this->port;
    }

    /**
     * Get Database.
     *
     * @return string|null
     */
    public function getDatabase(): ? string
    {
        return $this->database;
    }

    /**
     * Serialize configuration.
     *
     * @return string
     */
    public function serialize()
    {
        return json_encode([
            $this->host,
            $this->port,
            $this->database,
        ]);
    }
}
