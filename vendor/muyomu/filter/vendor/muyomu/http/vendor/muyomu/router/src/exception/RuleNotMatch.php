<?php

namespace muyomu\router\exception;

use Exception;

class RuleNotMatch extends Exception
{
    public function __construct()
    {
        parent::__construct("RuleNotMatch");
    }
}