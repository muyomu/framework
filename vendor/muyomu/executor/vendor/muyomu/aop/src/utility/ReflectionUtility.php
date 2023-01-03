<?php

namespace muyomu\aop\utility;

use muyomu\aop\exception\AopException;
use muyomu\log4p\Log4p;
use ReflectionClass;
use ReflectionException;
use ReflectionMethod;

class ReflectionUtility
{
    private Log4p $log4p;

    public function __construct()
    {
        $this->log4p = new Log4p();
    }

    /**
     * @throws AopException
     */
    public function getReflectionClass(string $className): ReflectionClass{
        try {
            $reflectionClass = new ReflectionClass($className);
        }catch (ReflectionException $exception){
            $this->log4p->muix_log_error(__CLASS__,__METHOD__,__LINE__,$exception->getMessage());
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
        }catch (ReflectionException $exception){
            $this->log4p->muix_log_error(__CLASS__,__METHOD__,__LINE__,$exception->getMessage());
            throw new AopException();
        }
        return $reflectionMethod;
    }
}