<?php

namespace muyomu\framework\exception;

use Exception;

class EnvConfigException extends Exception
{

    public function __construct()
    {
        parent::__construct("EnvConfigException");
    }
}