<?php

namespace muyomu\data\utility;

use ReflectionClass;
use ReflectionException;

class TableUtility
{
    /**
     * @throws ReflectionException
     */
    public static function getReflectClass(string $class):ReflectionClass{
        return new ReflectionClass($class);
    }
}