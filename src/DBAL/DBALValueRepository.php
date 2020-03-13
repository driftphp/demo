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

namespace Infrastructure\DBAL;

use Domain\ValueRepository;
use Drift\DBAL\Connection;
use React\Promise\PromiseInterface;

/**
 * Class DBALValueRepository
 */
class DBALValueRepository extends ValueRepository
{
    /**
     * @var string
     */
    const TABLE = 'key_value';

    /**
     * @var Connection
     */
    private $connection;

    /**
     * DBALValueRepository constructor.
     *
     * @param Connection $mainConnection
     */
    public function __construct(Connection $mainConnection)
    {
        $this->connection = $mainConnection;
    }

    /**
     * @inheritDoc
     */
    public function set(string $key, string $value): PromiseInterface
    {
        return $this
            ->connection
            ->upsert(self::TABLE, [
                'key' => $key
            ], [
                'value' => $value
            ]);
    }

    /**
     * @inheritDoc
     */
    public function delete(string $key): PromiseInterface
    {
        return $this
            ->connection
            ->delete(self::TABLE, [
                'key' => $key
            ]);
    }

    /**
     * @inheritDoc
     */
    public function loadAll(): PromiseInterface
    {
        return $this
            ->connection
            ->findBy(self::TABLE);
    }
}