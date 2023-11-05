<?php

namespace muyomu\aop;

use muyomu\aop\client\AopClient;
use muyomu\aop\exception\AopException;
use muyomu\aop\utility\AdviceResolver;
use muyomu\aop\utility\ReflectionUtility;
use ReflectionException;

class AopExecutor implements AopClient
{
    private ReflectionUtility $reflectionUtility;

    private AdviceResolver $adviceResolver;

    public function __construct()
    {
        $this->reflectionUtility = new ReflectionUtility();

        $this->adviceResolver = new AdviceResolver();
    }

    /**
     * @throws AopException
     * @throws ReflectionException
     */
    public function aopExecutor(object $instance, string $method, array $args): mixed
    {
        $reflectionClass = $this->reflectionUtility->getReflectionClass($instance::class);

        $reflectionMethod = $this->reflectionUtility->getReflectionMethod($reflectionClass,$method);

        return $this->adviceResolver->adviceResolverHandle($instance,$reflectionMethod,$args);
    }
}