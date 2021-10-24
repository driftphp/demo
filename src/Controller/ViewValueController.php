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
use Drift\Twig\Controller\RenderableController;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class ViewValueController.
 */
class ViewValueController implements RenderableController
{
    private QueryBus $queryBus;

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
     * @return array
     */
    public function __invoke(Request $request): array
    {
        $key = $request
            ->attributes
            ->get('key');

        return [
            'key' => $key,
            'value' => $this
                ->queryBus
                ->ask(new GetValue($key)),
        ];
    }

    /**
     * Get render template.
     *
     * @return string
     */
    public static function getTemplatePath(): string
    {
        return 'view_value.twig';
    }
}
