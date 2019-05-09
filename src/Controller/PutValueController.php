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
use React\Promise\FulfilledPromise;
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

        $value = $request->getContent(false);

        if (empty($value)) {
            return new RejectedPromise(new \Exception(
                'Value should have a non empty value'
            ));
        }

        return $this
            ->redisWrapper
            ->getClient()
            ->set($key, $value)
            ->then(function(string $response) use ($key, $value) {
                return new JsonResponse(
                    [
                        'key' => $key,
                        'value' => $value,
                        'message' => $response
                    ],
                    200
                );
            });
    }
}