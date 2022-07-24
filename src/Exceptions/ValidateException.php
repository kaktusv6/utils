<?php

namespace Utils\Exceptions;

class ValidateException extends \RuntimeException
{
    public function __construct(string $message)
    {
        return parent::__construct($message);
    }
}