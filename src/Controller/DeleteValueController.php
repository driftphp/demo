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

namespace App\Controller;

use Domain\Command\DeleteValue;
use Drift\CommandBus\Bus\CommandBus;
use React\Promise\PromiseInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class DeleteValueController.
 */
class DeleteValueController
{
    /**
     * @var CommandBus
     */
    private $commandBus;

    /**
     * DeleteValueController constructor.
     *
     * @param CommandBus $commandBus
     */
    public function __construct(CommandBus $commandBus)
    {
        $this->commandBus = $commandBus;
    }

    /**
     * Invoke.
     *
     * @param Request $request
     *
     * @return PromiseInterface
     */
    public function __invoke(Request $request)
    {
        $key = $request
            ->attributes
            ->get('key');

        return $this
            ->commandBus
            ->execute(new DeleteValue($key))
            ->then(function () use ($key) {
                return new JsonResponse(
                    [
                        'key' => $key,
                        'message' => 'Accepted',
                    ],
                    202
                );
            });
    }
}
