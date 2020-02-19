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

namespace Domain\CommandHandler;

use Domain\Command\PutValue;
use Domain\ValueRepository;
use React\Promise\PromiseInterface;

/**
 * Class PutValueHandler.
 */
final class PutValueHandler
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
     * Handle PutValue.
     *
     * @param PutValue $putValue
     *
     * @return PromiseInterface
     */
    public function handle(PutValue $putValue): PromiseInterface
    {
        return $this
            ->valueRepository
            ->set($putValue->getKey(), $putValue->getValue());
    }
}
