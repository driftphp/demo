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

use Domain\Query\GetValue;
use Drift\CommandBus\Bus\QueryBus;
use React\Promise\PromiseInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class GetValueController.
 */
class GetValueController
{
    /**
     * @var QueryBus
     */
    private $queryBus;

    /**
     * DeleteValueController constructor.
     *
     * @param QueryBus $queryBus
     */
    public function __construct(QueryBus $queryBus)
    {
        $this->queryBus = $queryBus;
    }

    /**
     * Invoke.
     *
     * @param Request $request
     *
     * @return PromiseInterface
     */
    public function __invoke(Request $request) : PromiseInterface
    {
        $key = $request
            ->attributes
            ->get('key');

        return $this
            ->queryBus
            ->ask(new GetValue($key))
            ->then(function ($value) use ($key) {
                return is_string($value)
                    ? new JsonResponse(
                        [
                            'key' => $key,
                            'value' => $value,
                        ],
                        200
                    )
                    : new Response('', 404);
            });
    }
}
