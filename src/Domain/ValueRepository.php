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
interface ValueRepository
{
    /**
     * Get value given a key.
     *
     * @param string $key
     *
     * @return string
     *
     * @throws KeyNotFoundException
     */
    public function get(string $key): ?string;

    /**
     * Get all keys and values.
     *
     * @return array
     */
    public function getAll(): array;

    /**
     * Set value given a key and a value.
     *
     * @param string $key
     * @param string $value
     *
     * @return PromiseInterface
     */
    public function set(
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
    public function delete(string $key): PromiseInterface;

    /**
     * Load locally.
     *
     * @return PromiseInterface
     */
    public function loadAll(): PromiseInterface;
}
