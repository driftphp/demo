<?php

namespace Domain\CommandHandler;

use Domain\Command\PutValue;
use Domain\ValueRepository;
use React\Promise\PromiseInterface;

/**
 * Class PutValueHandler
 */
final class PutValueHandler
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
     * Handle PutValue
     *
     * @param PutValue $putValue
     *
     * @return PromiseInterface
     */
    public function handle(PutValue $putValue) : PromiseInterface
    {
        return $this
            ->valueRepository
            ->set($putValue->getKey(), $putValue->getValue());
    }
}