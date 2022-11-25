<?php

namespace muyomu\database\exception;

use Exception;

class TypeNOtMatch extends Exception
{

    public function __construct()
    {
        parent::__construct("TypeNotMatch");
    }
}