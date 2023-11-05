<?php

namespace muyomu\aop\advicetype;

use Attribute;
use ReflectionClass;
use ReflectionException;

#[Attribute(Attribute::TARGET_METHOD)]
class BeforeAdvice
{
    private \muyomu\aop\advice\BeforeAdvice $beforeAdvice;

    private array $config;

    /**
     * @param \muyomu\aop\advice\BeforeAdvice $beforeAdvice
     * @param array $config
     */
    public function __construct(\muyomu\aop\advice\BeforeAdvice $beforeAdvice, array $config = array())
    {
        $this->beforeAdvice = $beforeAdvice;

        $this->config = $config;
    }

    /**
     * @return \muyomu\aop\advice\BeforeAdvice
     * @throws ReflectionException
     */
    public function getInstance(): \muyomu\aop\advice\BeforeAdvice
    {
        $reflectionClass = new ReflectionClass($this->beforeAdvice);

        return  $reflectionClass->newInstance();
    }

    /**
     * @return array
     */
    public function getConfig():array{
        return $this->config;
    }
}