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

return [
    Symfony\Bundle\FrameworkBundle\FrameworkBundle::class => ['all' => true],
    Drift\CommandBus\CommandBusBundle::class => ['all' => true],
    Drift\EventBus\EventBusBundle::class => ['all' => true],
    Drift\Twig\TwigBundle::class => ['all' => true],
    Drift\Preload\PreloadBundle::class => ['all' => true],
    Drift\AMQP\AMQPBundle::class => ['all' => true],
    Drift\DBAL\DBALBundle::class => ['all' => true],
    Drift\Websocket\WebsocketBundle::class => ['all' => true],
];
