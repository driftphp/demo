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
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class DeleteValueController
 */
class DeleteValueController
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
     * @return PromiseInterface
     */
    public function __invoke(Request $request)
    {
        $key = $request
            ->attributes
            ->get('key');

        return $this
            ->valueRepository
            ->delete($key)
            ->then(function(string $response) use ($key) {
                return new JsonResponse(
                    [
                        'key' => $key,
                        'message' => $response === '1'
                            ? 'OK'
                            : 'Key not found'
                        ,
                    ],
                    200
                );
            });
    }
}