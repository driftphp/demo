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

namespace Domain;

use React\Promise\PromiseInterface;

/**
 * Class ValueRepository.
 */
abstract class ValueRepository
{
    /**
     * @var array
     */
    private $localValues = [];

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
     * Reload all database
     *
     * @return PromiseInterface
     */
    public function reloadDatabase(): PromiseInterface
    {
        return $this
            ->loadAll()
            ->then(function($keyValues) {
                $this->localValues = [];
                foreach ($keyValues as $keyValue) {
                    $this->localValues[$keyValue['id']] = $keyValue['value'];
                }
            });
    }

    /**
     * Set value given a key and a value.
     *
     * @param string $key
     * @param string $value
     *
     * @return PromiseInterface
     */
    abstract public function set(
        string $key,
        string $value
    ): PromiseInterface;

    /**
     * Delete value given a key.
     *
     * @param string $key
     *
     * @return PromiseInterface
     */
    abstract public function delete(string $key): PromiseInterface;

    /**
     * Load locally.
     *
     * @return PromiseInterface
     */
    abstract public function loadAll(): PromiseInterface;
}
