<?php

namespace muyomu\executor\client;

use muyomu\http\Request;
use muyomu\http\Response;
use ReflectionClass;
use ReflectionMethod;

interface ExecutorHelper
{
    public function getReflectionClass(Response $response,string $class):ReflectionClass;

    public function getControllerInstance(Response $response,ReflectionClass $reflectionClass):mixed;

    public function injectRR(Request $request,Response $response,ReflectionClass $reflectionClass,mixed $instance):void;

    public function getControllerHandle(ReflectionClass $reflectionClass,string $handle): ReflectionMethod;

    public function handleExecutor(mixed $instance,ReflectionMethod $method,array $argv):mixed;
}