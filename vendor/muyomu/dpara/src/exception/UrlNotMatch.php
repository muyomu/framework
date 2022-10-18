<?php

namespace muyomu\dpara\exception;

use Exception;

class UrlNotMatch extends Exception
{

    public function __construct()
    {
        parent::__construct("UrlNotMatch");
    }
}