<?php

namespace muyomu\data\utility;

use muyomu\data\client\SqlQueryForFun;
use mysqli;
use mysqli_result;
use ReflectionException;
use ReflectionMethod;

class SqlExecutorForFun implements SqlQueryForFun
{
    private SqlUtility $sqlUtility;

    public function __construct(){

        $this->sqlUtility = new SqlUtility();
    }

    /**
     * @throws ReflectionException
     */
    public function sqlExecutor(mysqli $con, object $class, ReflectionMethod $method, array $args): bool | mysqli_result
    {
        return $con->query($this->sqlUtility->getSql($class, $method, $args));
    }
}