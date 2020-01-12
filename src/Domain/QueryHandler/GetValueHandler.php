<?php

namespace Domain\QueryHandler;

use Domain\KeyNotFoundException;
use Domain\Query\GetValue;
use Domain\ValueRepository;
use React\Promise\PromiseInterface;

/**
 * Class GetValueHandler
 */
final class GetValueHandler
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
     * Handle GetValue
     *
     * @param GetValue $getValue
     *
     * @return PromiseInterface
     */
    public function handle(GetValue $getValue) : PromiseInterface
    {
        return $this
            ->valueRepository
            ->get($getValue->getKey())
            ->then(null, function(KeyNotFoundException $exception) {
                return null;
            });
    }
}