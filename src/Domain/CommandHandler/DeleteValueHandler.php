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

use Domain\Command\DeleteValue;
use Domain\ValueRepository;
use React\Promise\PromiseInterface;

/**
 * Class DeleteValueHandler.
 */
final class DeleteValueHandler
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
     * Handle DeleteValue.
     *
     * @param DeleteValue $deleteValue
     *
     * @return PromiseInterface
     */
    public function handle(DeleteValue $deleteValue): PromiseInterface
    {
        return $this
            ->valueRepository
            ->delete($deleteValue->getKey());
    }
}
