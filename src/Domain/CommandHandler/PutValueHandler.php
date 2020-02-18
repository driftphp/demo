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
use Domain\Event\ValueHasBeenPut;
use Domain\ValueRepository;
use Drift\EventBus\Bus\EventBus;
use React\Promise\PromiseInterface;

/**
 * Class PutValueHandler.
 */
final class PutValueHandler
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
     * Handle PutValue.
     *
     * @param PutValue $putValue
     *
     * @return PromiseInterface
     */
    public function handle(PutValue $putValue): PromiseInterface
    {
        $key = $putValue->getKey();
        $value = $putValue->getValue();

        return $this
            ->valueRepository
            ->set($key, $value)
            ->then(function () use ($key, $value) {
                return $this
                    ->eventBus
                    ->dispatch(new ValueHasBeenPut(
                        $key,
                        $value
                    ));
            });
    }
}
