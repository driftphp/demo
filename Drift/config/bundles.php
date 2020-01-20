<?php

return [
    Symfony\Bundle\FrameworkBundle\FrameworkBundle::class => ['all' => true],
    Drift\CommandBus\CommandBusBundle::class => ['all' => true],
    Drift\Redis\RedisBundle::class => ['all' => true],
    Drift\Twig\TwigBundle::class => ['all' => true],
    Drift\Preload\PreloadBundle::class => ['all' => true],
    Drift\AMQP\AMQPBundle::class => ['all' => true],
];
