<?php

namespace muyomu\data\exception;

use Exception;

class AttributeNotTagException extends Exception
{
    public function __construct()
    {
        parent::__construct("QueryAttributeNotTagException");
    }
}