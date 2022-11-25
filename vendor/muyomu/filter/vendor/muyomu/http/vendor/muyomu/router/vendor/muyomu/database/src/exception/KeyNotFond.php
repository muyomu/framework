<?php

namespace muyomu\database\exception;

use Exception;

class KeyNotFond extends Exception
{

    public function __construct()
    {
        parent::__construct("keyNotFond");
    }
}