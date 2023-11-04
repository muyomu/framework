<?php

namespace muyomu\executor\exception;

use Exception;

class ExecutorException extends Exception
{
    public function __construct()
    {
        parent::__construct("Server Exception");
    }
}