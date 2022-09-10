<?php

namespace Utils\Exceptions;

class ValidateException extends \RuntimeException
{
    public function __construct(string $class, string $message)
    {
        return parent::__construct(sprintf('%s: %s', $class, $message));
    }
}
