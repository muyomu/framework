<?php

namespace muyomu\aop;

use muyomu\aop\client\FrameClient;
use muyomu\aop\utility\AdviceResolver;
use ReflectionException;
use ReflectionMethod;

class FrameworkExecutor implements FrameClient
{
    private AdviceResolver $adviceResolver;

    public function __construct()
    {
        $this->adviceResolver = new AdviceResolver();
    }

    /**
     * @throws ReflectionException
     */
    public function aopExecutor(object $instance, ReflectionMethod $method, array $args): mixed
    {
        return $this->adviceResolver->adviceResolverHandle($instance,$method,$args);
    }
}