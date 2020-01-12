<?php

namespace Domain\QueryHandler;

use Domain\Query\GetValues;
use Domain\ValueRepository;
use React\Promise\PromiseInterface;

/**
 * Class GetValuesHandler
 */
final class GetValuesHandler
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
     * Handle GetValues
     *
     * @param GetValues $getValues
     *
     * @return PromiseInterface
     */
    public function handle(GetValues $getValues) : PromiseInterface
    {
        return $this
            ->valueRepository
            ->getAll();
    }
}