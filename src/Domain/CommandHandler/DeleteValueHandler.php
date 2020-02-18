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
use Domain\Event\ValueHasBeenDeleted;
use Domain\ValueRepository;
use Drift\EventBus\Bus\EventBus;
use React\Promise\PromiseInterface;

/**
 * Class DeleteValueHandler.
 */
final class DeleteValueHandler
{
    /**
     * @var ValueRepository
     */
    private $valueRepository;

    /**
     * @var EventBus
     */
    private $eventBus;

    /**
     * DeleteValueHandler constructor.
     *
     * @param ValueRepository $valueRepository
     * @param EventBus        $eventBus
     */
    public function __construct(
        ValueRepository $valueRepository,
        EventBus $eventBus
    ) {
        $this->valueRepository = $valueRepository;
        $this->eventBus = $eventBus;
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
        $key = $deleteValue->getKey();

        return $this
            ->valueRepository
            ->delete($key)
            ->then(function () use ($key) {
                return $this
                    ->eventBus
                    ->dispatch(new ValueHasBeenDeleted($key));
            });
    }
}
