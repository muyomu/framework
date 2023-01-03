<?php

namespace muyomu\inject;

use muyomu\inject\client\ProxyClient;
use muyomu\inject\utility\ReflectionTypeStrategy;
use ReflectionException;

class Proxy implements ProxyClient
{
    private ReflectionTypeStrategy $reflectionTypeStrategy;

    public function __construct()
    {
        $this->reflectionTypeStrategy = new ReflectionTypeStrategy();
    }

    /**
     * @throws ReflectionException
     */
    public function getProxyInstance(mixed $classOrInstance): object
    {
        $type = gettype($classOrInstance);
        $this->reflectionTypeStrategy->setStatus($type);
        return $this->reflectionTypeStrategy->getInstance($classOrInstance);
    }
}