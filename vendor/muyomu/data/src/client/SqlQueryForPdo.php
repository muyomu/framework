<?php

namespace muyomu\data\client;

use PDO;
use ReflectionClass;
use ReflectionMethod;

interface SqlQueryForPdo
{
    public function sqlExecutor(PDO $con, ReflectionClass $class, ReflectionMethod $method, array $args):bool | \PDOStatement;
}