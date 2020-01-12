<?php

/*
 * This file is part of the DriftPHP Demo.
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

use Domain\Command\PutValue;
use Drift\Bus\Bus\CommandBus;
use React\Promise\PromiseInterface;
use React\Promise\RejectedPromise;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class PutValueController
 */
class PutValueController
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
     * Invoke
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

        $value = $request->getContent(false);

        if (empty($value)) {
            return new RejectedPromise(new \Exception(
                'Value should have a non empty value'
            ));
        }

        return $this
            ->commandBus
            ->execute(new PutValue($key, $value))
            ->then(function() use ($key, $value) {
                return new JsonResponse(
                    [
                        'key' => $key,
                        'value' => $value
                    ],
                    200
                );
            });
    }
}