<?php

namespace muyomu\http\exception;

use Exception;

class ParaNotExit extends Exception
{

    public function __construct()
    {
        parent::__construct("ParaNotExit");
    }
}