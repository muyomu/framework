<?php

namespace muyomu\aop\exception;

use Exception;

class AopException extends Exception
{

    public function __construct()
    {
        parent::__construct("Aop client can't be done because class not exit");
    }
}