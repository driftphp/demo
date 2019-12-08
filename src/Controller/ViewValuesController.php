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
     * @var ValueRepository
     *
     * Value Repository
     */
    private $valueRepository;
    private $twig;

    /**
     * PutValueController constructor.
     *
     * @param ValueRepository $valueRepository
     * @param Environment $twig
     */
    public function __construct(
        ValueRepository $valueRepository,
        Environment $twig
    )
    {
        $this->valueRepository = $valueRepository;
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
            ->valueRepository
            ->getAll()
            ->then(function(array $values) {
                $template = $this->twig->load('redis/view_values.twig');
                return new Response(
                    $template->render([
                        'values' => $values
                    ]),
                    200
                );
            });
    }
}