<?php



namespace Domain\Query;

/**
 * Class GetValue
 */
final class GetValue
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