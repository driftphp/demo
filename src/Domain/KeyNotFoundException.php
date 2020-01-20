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

use Exception;

/**
 * Class KeyNotFoundException.
 */
final class KeyNotFoundException extends Exception
{
    /**
     * Create key not found.
     *
     * @param string $key
     *
     * @return self
     */
    public static function createFromKey(string $key): self
    {
        return new self(sprintf('Key %s not found in repository', $key));
    }
}
