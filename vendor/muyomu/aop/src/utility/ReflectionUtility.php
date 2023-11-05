<?php

namespace muyomu\aop\utility;

use muyomu\aop\exception\AopException;
use ReflectionClass;
use ReflectionException;
use ReflectionMethod;

class ReflectionUtility
{
    /**
     * @throws AopException
     */
    public function getReflectionClass(string $className): ReflectionClass{
        try {
            $reflectionClass = new ReflectionClass($className);
        }catch (ReflectionException){
            throw new AopException();
        }
        return $reflectionClass;
    }

    /**
     * @throws AopException
     */
    public function getReflectionMethod(ReflectionClass $reflectionClass, string $method): ReflectionMethod{
        try {
            $reflectionMethod = $reflectionClass->getMethod($method);
        }catch (ReflectionException){
            throw new AopException();
        }
        return $reflectionMethod;
    }
}