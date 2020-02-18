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

namespace Domain\EventListener;

use Domain\Event\ValueHasBeenDeleted;
use Domain\Event\ValueHasBeenPut;
use Domain\ValueRepository;
use React\Promise\PromiseInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Contracts\EventDispatcher\Event;

/**
 * Class LocalDatabaseListener.
 */
final class LocalDatabaseListener implements EventSubscriberInterface
{
    /**
     * @var ValueRepository
     */
    private $valueRepository;

    /**
     * LocalDatabaseListener constructor.
     *
     * @param ValueRepository $valueRepository
     */
    public function __construct(ValueRepository $valueRepository)
    {
        $this->valueRepository = $valueRepository;
    }

    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents()
    {
        return [
            ValueHasBeenDeleted::class => [
                ['updateLocalDatabaseLayer', 0],
            ],

            ValueHasBeenPut::class => [
                ['updateLocalDatabaseLayer', 0],
            ],
        ];
    }

    /**
     * @param Event $event
     *
     * @return PromiseInterface
     */
    public function updateLocalDatabaseLayer(Event $event): PromiseInterface
    {
        return $this
            ->valueRepository
            ->loadAll();
    }
}
