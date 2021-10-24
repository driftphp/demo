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

use Domain\Query\GetValues;
use Drift\CommandBus\Bus\QueryBus;
use Drift\Twig\Controller\RenderableController;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class IndexController.
 */
class IndexController implements RenderableController
{
    private QueryBus $queryBus;
    private string $websocketPort;

    /**
     * DeleteValueController constructor.
     *
     * @param QueryBus    $queryBus
     * @param string $websocketPort
     */
    public function __construct(
        QueryBus $queryBus,
        string $websocketPort
    ) {
        $this->queryBus = $queryBus;
        $this->websocketPort = $websocketPort;
    }

    /**
     * Invoke.
     *
     * @param Request $request
     *
     * @return array
     */
    public function __invoke(Request $request) : array
    {
        return [
            'websocket_port' => $this->websocketPort,
            'values' => $this
                ->queryBus
                ->ask(new GetValues())
        ];
    }

    /**
     * @inheritDoc
     */
    public static function getTemplatePath(): string
    {
        return 'index.twig';
    }
}
