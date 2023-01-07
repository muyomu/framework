<?php

namespace muyomu\punit;

use muyomu\inject\Proxy;
use ReflectionClass;
use ReflectionException;

abstract class GenericTest implements PUnitTest
{
    public static function run(string $class):void{
        $proxy = new Proxy();
        try {
            $reflectionClass = new ReflectionClass($class);
            $reflectionMethod = $reflectionClass->getMethod("Test");
            $instance = $reflectionClass->newInstance();
            $proxyInstance = $proxy->getProxyInstance($instance);
            $reflectionMethod->invoke($proxyInstance);
        }catch (ReflectionException $exception){
            echo "ERROR:\r\n";
            echo "\r\n";
            echo $exception->getMessage();
        }
    }
}