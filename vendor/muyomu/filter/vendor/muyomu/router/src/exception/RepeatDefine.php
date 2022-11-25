<?php

namespace muyomu\router\exception;

use Exception;

class RepeatDefine extends Exception
{

    public function __construct()
    {
        parent::__construct("RepeatDefine");
    }
}