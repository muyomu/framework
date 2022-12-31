<?php

namespace muyomu\framework\exception;

use Exception;

class HeaderNotFoundException extends Exception
{
        public function __construct()
        {
             parent::__construct("HeaderNotFoundException");
        }
}