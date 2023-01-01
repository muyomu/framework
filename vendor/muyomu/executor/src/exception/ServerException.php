<?php

namespace muyomu\executor\exception;

use Exception;

class ServerException extends Exception
{

    public function __construct()
    {
        parent::__construct("ServerException");
    }
}