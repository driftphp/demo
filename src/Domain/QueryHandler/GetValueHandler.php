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

namespace Domain\QueryHandler;

use Domain\KeyNotFoundException;
use Domain\Query\GetValue;
use Domain\ValueRepository;

/**
 * Class GetValueHandler.
 */
final class GetValueHandler
{
    /**
     * @var ValueRepository
     *
     * Value Repository
     */
    private $valueRepository;

    /**
     * PutValueController constructor.
     *
     * @param ValueRepository $valueRepository
     */
    public function __construct(ValueRepository $valueRepository)
    {
        $this->valueRepository = $valueRepository;
    }

    /**
     * Handle GetValue.
     *
     * @param GetValue $getValue
     *
     * @return string|null
     */
    public function handle(GetValue $getValue): ?string
    {
        $value = null;
        try {
            $value = $this
                ->valueRepository
                ->get($getValue->getKey());
        } catch (KeyNotFoundException $exception) {
            // Silent pass
        }

        return $value;
    }
}
