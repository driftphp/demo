<?php


namespace Domain;

use Exception;

/**
 * Class KeyNotFoundException
 */
final class KeyNotFoundException extends Exception
{
    /**
     * Create key not found
     *
     * @param string $key
     *
     * @return self
     */
    public static function createFromKey(string $key) : self
    {
        return new self(sprintf("Key %s not found in repository", $key));
    }
}