<?php

namespace muyomu\data\exception;

use Exception;

class MysqlConnectException extends Exception
{
    public function __construct()
    {
        parent::__construct("Data error");
    }
}