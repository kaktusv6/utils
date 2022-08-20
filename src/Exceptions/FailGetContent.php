<?php

namespace Utils\Exceptions;

class FailGetContent extends \Exception
{
    public function __construct()
    {
        parent::__construct('Fail get content');
    }
}
