<?php

namespace muyomu\framework\exception;

use Exception;

class MethodNotMatch extends Exception
{
        public function __construct()
        {
             parent::__construct("MethodNotMatch");
        }
}