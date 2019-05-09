<?php

namespace App\Controller;

/*
 * This file is part of the {Package name}.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * Feel free to edit as you please, and have fun.
 *
 * @author Marc Morera <yuhu@mmoreram.com>
 */
use App\Redis\RedisWrapper;
use React\Promise\PromiseInterface;
use React\Promise\RejectedPromise;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class DeleteValueController
 */
class DeleteValueController
{
    /**
     * @var RedisWrapper
     *
     * Redis Wrapper
     */
    private $redisWrapper;

    /**
     * PutValueController constructor.
     *
     * @param RedisWrapper $redisWrapper
     */
    public function __construct(RedisWrapper $redisWrapper)
    {
        $this->redisWrapper = $redisWrapper;
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
            ->redisWrapper
            ->getClient()
            ->del($key)
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