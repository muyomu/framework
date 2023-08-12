<?php

namespace muyomu\executor\exception;

use Exception;

class ParaMissException extends Exception
{
    public function __construct(string $message)
    {
        parent::__construct($message);
    }

}