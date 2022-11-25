<?php

namespace muyomu\http\exception;

use Exception;

class HeaderNotFound extends Exception
{

    public function __construct()
    {
        parent::__construct("HeaderNotFound");
    }
}