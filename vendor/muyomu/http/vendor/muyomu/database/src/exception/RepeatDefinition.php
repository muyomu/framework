<?php

namespace muyomu\database\exception;

use Exception;

class RepeatDefinition extends Exception
{

    public function __construct()
    {
        parent::__construct("RepeatDefinition");
    }
}