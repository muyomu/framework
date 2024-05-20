<?php

namespace muyomu\inject;

use muyomu\inject\client\ProxyClient;
use muyomu\inject\utility\ReflectionTypeStrategy;
use ReflectionException;

class ProxyExecutor implements ProxyClient
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
        //获取参数类型
        $type = gettype($classOrInstance);

        //设置策略状态
        $this->reflectionTypeStrategy->setStatus($type);

        //执行策略
        return $this->reflectionTypeStrategy->getInstance($classOrInstance);
    }
}