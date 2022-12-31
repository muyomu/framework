<?php

namespace muyomu\framework\exception;

use Exception;

class ProtocolVersionSupportException extends Exception
{

    public function __construct()
    {
        parent::__construct("ProtocolVersionSupportException");
    }
}