<?php

namespace muyomu\data\client;

use mysqli;
use mysqli_result;
use ReflectionClass;
use ReflectionMethod;

interface SqlQueryForFun
{
    public function sqlExecutor(Mysqli $con, ReflectionClass $class, ReflectionMethod $method, array $args):bool | mysqli_result;
}