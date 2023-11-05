<?php

namespace muyomu\aop\advicetype;

use Attribute;
use ReflectionClass;
use ReflectionException;

#[Attribute(Attribute::TARGET_METHOD)]
class AfterAdvice
{
    private \muyomu\aop\advice\AfterAdvice $afterAdvice;

    private array $config;

    /**
     * @param \muyomu\aop\advice\AfterAdvice $afterAdvice
     * @param array $config
     */
    public function __construct(\muyomu\aop\advice\AfterAdvice $afterAdvice, array $config = array())
    {
        $this->afterAdvice = $afterAdvice;

        $this->config = $config;
    }

    /**
     * @return \muyomu\aop\advice\AfterAdvice
     * @throws ReflectionException
     */
    public function getInstance(): \muyomu\aop\advice\AfterAdvice
    {
        $reflectionClass = new ReflectionClass($this->afterAdvice);

        return $reflectionClass->newInstance();
    }

    /**
     * @return array
     */
    public function getConfig():array{
        return $this->config;
    }
}