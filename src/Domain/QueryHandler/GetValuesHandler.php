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

use Domain\Query\GetValues;
use Domain\ValueRepository;

/**
 * Class GetValuesHandler.
 */
final class GetValuesHandler
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
     * Handle GetValues.
     *
     * @param GetValues $getValues
     *
     * @return array
     */
    public function handle(GetValues $getValues): array
    {
        return $this
            ->valueRepository
            ->getAll();
    }
}
