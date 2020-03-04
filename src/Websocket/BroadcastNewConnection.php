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
use Drift\Websocket\Event\WebsocketConnectionOpened;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Class BroadcastNewConnection
 */
class BroadcastNewConnection implements EventSubscriberInterface
{
    /**
     * @param WebsocketConnectionOpened $event
     */
    public function broadcast(WebsocketConnectionOpened $event)
    {
        $event
            ->getConnections()
            ->broadcast(json_encode([
                'type' => 'connection_opened',
                'route' => $event->getRoute(),
                'from' => Connection::getConnectionHash($event->getConnection()),
                'value' => 'Connection opened'
            ]));
    }

    /**
     * @inheritDoc
     */
    public static function getSubscribedEvents()
    {
        return [
            WebsocketConnectionOpened::class => [
                ['broadcast', 0]
            ]
        ];
    }
}