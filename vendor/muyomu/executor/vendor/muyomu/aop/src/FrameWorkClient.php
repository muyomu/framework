<?php

namespace muyomu\aop;

use muyomu\aop\client\FrameClient;
use muyomu\aop\utility\ReflectionUtility;
use ReflectionException;
use ReflectionMethod;

class FrameWorkClient implements FrameClient
{
    private ReflectionUtility $reflectionUtility;

    public function __construct()
    {
        $this->reflectionUtility = new ReflectionUtility();
    }

    /**
     * @throws ReflectionException
     */
    public function aopExecutor(object $instance, ReflectionMethod $method, mixed $args): mixed
    {
        $reflectionMethod = $method;

        return $this->reflectionUtility->adviceResolverHandle($instance,$reflectionMethod,$args);
    }
}