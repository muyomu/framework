<?php

namespace muyomu\data\exception;

use Exception;

class MysqlConfigNotMatch extends Exception
{

    public function __construct()
    {
        parent::__construct("MysqlConfigNotMatch");
    }
}