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

use Domain\Query\GetValues;
use Drift\CommandBus\Bus\QueryBus;
use React\Promise\PromiseInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;

/**
 * Class ViewValuesController
 */
class ViewValuesController
{
    /**
     * @var QueryBus
     */
    private $queryBus;

    /**
     * DeleteValueController constructor.
     *
     * @param QueryBus $queryBus
     * @param Environment $twig
     */
    public function __construct(
        QueryBus $queryBus,
        Environment $twig
    )
    {
        $this->queryBus = $queryBus;
        $this->twig = $twig;
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
        return $this
            ->queryBus
            ->ask(new GetValues)
            ->then(function(array $values) {
                $template = $this->twig->load('redis/view_values.twig');
                $value = $template->render([
                    'values' => $values
                ]);

                return new Response(
                    $value,
                    200
                );
            });
    }
}