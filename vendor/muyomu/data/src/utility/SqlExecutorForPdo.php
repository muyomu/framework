<?php

namespace muyomu\data\utility;

use PDO;
use PDOStatement;
use ReflectionException;
use ReflectionMethod;
use muyomu\data\client\SqlQueryForPdo;

class SqlExecutorForPdo implements SqlQueryForPdo
{
    private SqlUtility $sqlUtility;

    public function __construct(){

        $this->sqlUtility = new SqlUtility();
    }

    /**
     * @throws ReflectionException
     */
    public function sqlExecutor(PDO $con, object $class, ReflectionMethod $method, array $args): bool | PDOStatement
    {
        return $con->query($this->sqlUtility->getSql($class, $method, $args));
    }
}