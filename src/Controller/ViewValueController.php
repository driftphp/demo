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

use Domain\ValueRepository;
use Drift\Twig\Controller\RenderableController;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class ViewValueController
 */
class ViewValueController implements RenderableController
{
    /**
     * @var ValueRepository
     *
     * Value Repository
     */
    private $valueRepository;

    /**
     * PutValueController constructor.
     *
     * @param ValueRepository $valueRepository
     */
    public function __construct(ValueRepository $valueRepository)
    {
        $this->valueRepository = $valueRepository;
    }

    /**
     * Invoke
     *
     * @param Request $request
     *
     * @return array
     */
    public function __invoke(Request $request) : array
    {
        $key = $request
            ->attributes
            ->get('key');

        return [
            'key' => $key,
            'value' => $this
                ->valueRepository
                ->get($key)
        ];
    }

    /**
     * Get render template
     *
     * @return string
     */
    public static function getTemplatePath(): string
    {
        return 'redis/view_value.twig';
    }
}