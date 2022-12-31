<?php

namespace muyomu\framework\exception;

use Exception;

class MethodNotMatchException extends Exception
{
        public function __construct()
        {
             parent::__construct("MethodNotMatchException");
        }
}