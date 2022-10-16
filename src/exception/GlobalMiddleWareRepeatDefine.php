<?php

namespace muyomu\framework\exception;

use Exception;

class GlobalMiddleWareRepeatDefine extends Exception
{

    public function __construct()
    {
        parent::__construct("GlobalMiddleWareRepeatDefine");
    }
}