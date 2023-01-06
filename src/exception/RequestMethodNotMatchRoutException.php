<?php

namespace muyomu\framework\exception;

use Exception;

class RequestMethodNotMatchRoutException extends Exception
{

    public function __construct()
    {
        parent::__construct("RequestMethodNotMatchRoutException");
    }
}