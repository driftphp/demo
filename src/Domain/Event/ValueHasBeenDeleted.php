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

namespace Domain\Event;

/**
 * Class ValueHasBeenDeleted.
 */
final class ValueHasBeenDeleted
{
    /**
     * @var string
     */
    private $key;

    /**
     * ValueHasBeenDeleted constructor.
     *
     * @param string $key
     */
    public function __construct(string $key)
    {
        $this->key = $key;
    }

    /**
     * @return string
     */
    public function getKey(): string
    {
        return $this->key;
    }

    /**
     * To array
     *
     * @return array
     */
    public function toArray() : array
    {
        return [
            'event' => 'value_deleted',
            'key' => $this->key,
        ];
    }
}
