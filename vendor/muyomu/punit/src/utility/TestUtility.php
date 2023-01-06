<?php

namespace muyomu\punit\utility;

use muyomu\aop\AopExecutor;
use muyomu\aop\exception\AopException;
use muyomu\inject\Proxy;
use muyomu\punit\generic\TestCase;
use ReflectionException;

class TestUtility implements TestCase
{
    private Proxy $proxy;

    private AopExecutor $executor;

    public function __construct()
    {
        $this->proxy = new Proxy();
        $this->executor = new AopExecutor();
    }


    /**
     * @throws ReflectionException
     * @throws AopException
     */
    public function Test(mixed $instanceOrClassname, string $method, array $args): mixed
    {
        $proxyInstance = $this->proxy->getProxyInstance($instanceOrClassname);
        return $this->executor->aopExecutor($proxyInstance,$method,$args);
    }
}