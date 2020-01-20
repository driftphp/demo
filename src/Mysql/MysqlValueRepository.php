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

namespace Infrastructure\Mysql;

use Domain\KeyNotFoundException;
use Domain\ValueRepository;
use React\MySQL\ConnectionInterface;
use React\MySQL\QueryResult;
use React\Promise\PromiseInterface;

/**
 * Class MysqlValueRepository.
 */
class MysqlValueRepository implements ValueRepository
{
    /**
     * @var ConnectionInterface
     *
     * Mysql connection
     */
    private $connection;

    /**
     * @var string
     *
     * Prefix
     */
    private const TABLE = 'demo';

    /**
     * PutValueController constructor.
     *
     * @param ConnectionInterface $connection
     */
    public function __construct(ConnectionInterface $connection)
    {
        $this->connection = $connection;
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
            ->connection
            ->query('INSERT INTO demo (key, value) VALUES (?, ?)', [
                $key,
                $value,
            ]);
    }

    /**
     * Get value given a key.
     *
     * @param string $key
     *
     * @return PromiseInterface
     */
    public function get(string $key): PromiseInterface
    {
        return $this
            ->connection
            ->query('SELECT d.key as `key`, d.value as `value` from demo d WHERE `key` = ?', [
                $key,
            ])
            ->then(function (QueryResult $result) use ($key) {
                if (empty($result->resultRows)) {
                    throw KeyNotFoundException::createFromKey($key);
                }

                return $result->resultRows[0]['value'];
            });
    }

    /**
     * Get all keys and values.
     *
     * @return PromiseInterface
     */
    public function getAll(): PromiseInterface
    {
        return $this
            ->connection
            ->query('SELECT d.key as `key`, d.value as `value` from demo d')
            ->then(function (QueryResult $result) {
                $values = [];
                foreach ($result->resultRows as $value) {
                    $values[$value['key']] = $value['value'];
                }

                return $values;
            });
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
            ->connection
            ->query('DELETE FROM demo (key, value) WHERE id = ?', [
                $key,
            ]);
    }
}
