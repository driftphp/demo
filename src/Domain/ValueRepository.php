<?php

/*
 * This file is part of the DriftPHP Demo.
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
 * Class ValueRepository
 */
interface ValueRepository
{
    /**
     * Set value given a key and a value
     *
     * @param string $key
     * @param string $value
     *
     * @return PromiseInterface
     */
    public function set(
        string $key,
        string $value
    ) : PromiseInterface;

    /**
     * Get value given a key
     *
     * @param string $key
     *
     * @return PromiseInterface
     */
    public function get(string $key) : PromiseInterface;

    /**
     * Get all keys and values
     *
     * @return PromiseInterface
     */
    public function getAll() : PromiseInterface;

    /**
     * Delete value given a key
     *
     * @param string $key
     *
     * @return PromiseInterface
     */
    public function delete(string $key) : PromiseInterface;
}