<?php

namespace muyomu\executor\exception;

use Exception;

class UnKnownPara extends Exception
{
    public function __construct(string $message)
    {
        parent::__construct($message);
    }
}