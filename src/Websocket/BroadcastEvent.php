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

namespace App\Websocket;


use Domain\Event\ValueHasBeenDeleted;
use Domain\Event\ValueHasBeenPut;
use Drift\HttpKernel\Event\DomainEventEnvelope;
use Drift\Websocket\Connection\Connections;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Class BroadcastEvent
 */
class BroadcastEvent implements EventSubscriberInterface
{
    /**
     * @var Connections
     */
    private $connections;

    /**
     * NotifyEvent constructor.
     *
     * @param Connections $eventsConnections
     */
    public function __construct(Connections $eventsConnections)
    {
        $this->connections = $eventsConnections;
    }

    /**
     * @param DomainEventEnvelope $event
     */
    public function broadcast(DomainEventEnvelope $event)
    {
        $domainEvent = $event->getDomainEvent();
        $eventNamespaceParts = explode('\\', get_class($domainEvent));

        $this
            ->connections
            ->broadcast(json_encode([
                'type' => 'domain_event',
                'route' => 'events',
                'from' => 'Domain Event',
                'value' => end($eventNamespaceParts),
                'event' => $domainEvent->toArray(),
            ]));
    }

    /**
     * @inheritDoc
     */
    public static function getSubscribedEvents()
    {
        return [
            ValueHasBeenPut::class => [['broadcast', 0]],
            ValueHasBeenDeleted::class => [['broadcast', 0]],
        ];
    }
}
