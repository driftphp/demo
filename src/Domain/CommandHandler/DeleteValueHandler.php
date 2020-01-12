<?php

namespace Domain\CommandHandler;

use Domain\Command\DeleteValue;
use Domain\ValueRepository;
use React\Promise\PromiseInterface;

/**
 * Class DeleteValueHandler
 */
final class DeleteValueHandler
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
     * Handle DeleteValue
     *
     * @param DeleteValue $deleteValue
     *
     * @return PromiseInterface
     */
    public function handle(DeleteValue $deleteValue) : PromiseInterface
    {
        return $this
            ->valueRepository
            ->delete($deleteValue->getKey());
    }
}