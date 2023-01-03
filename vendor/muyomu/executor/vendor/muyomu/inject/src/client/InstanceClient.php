<?php

namespace muyomu\inject\client;

use ReflectionClass;
use ReflectionProperty;

interface InstanceClient
{
    public function getInstance(mixed $classOrInstance):object;

    public function getInstanceWithNoInstance(string $className):object;

    public function fillProperty(string $className, ReflectionProperty $reflectionProperty, object $instance):void;

    public function getInstanceWithInstance(string $className,object $instance):object;
}