<?php



namespace Domain\Command;

/**
 * Class DeleteValue
 */
final class DeleteValue
{
    /**
     * @var string
     */
    private $key;

    /**
     * GetValue constructor.
     *
     * @param string $key
     */
    public function __construct(string $key)
    {
        $this->key = $key;
    }

    /**
     * @return string
     */
    public function getKey(): string
    {
        return $this->key;
    }
}