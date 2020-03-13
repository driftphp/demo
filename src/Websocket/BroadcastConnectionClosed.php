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


use Drift\Websocket\Connection\Connection;
use Drift\Websocket\Event\WebsocketConnectionClosed;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Class BroadcastConnectionClosed
 */
class BroadcastConnectionClosed implements EventSubscriberInterface
{
    /**
     * @param WebsocketConnectionClosed $event
     */
    public function broadcast(WebsocketConnectionClosed $event)
    {
        $event
            ->getConnections()
            ->broadcast(json_encode([
                'type' => 'connection_closed',
                'route' => $event->getRoute(),
                'from' => Connection::getConnectionHash($event->getConnection()),
                'value' => 'Connection closed'
            ]));
    }

    /**
     * @inheritDoc
     */
    public static function getSubscribedEvents()
    {
        return [
            WebsocketConnectionClosed::class => [
                ['broadcast', 0]
            ]
        ];
    }
}