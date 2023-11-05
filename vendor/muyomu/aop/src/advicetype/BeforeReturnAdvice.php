<?php

namespace muyomu\aop\advicetype;

use Attribute;
use ReflectionClass;
use ReflectionException;

#[Attribute(Attribute::TARGET_METHOD)]
class BeforeReturnAdvice
{
    private \muyomu\aop\advice\BeforeReturnAdvice $beforeReturnAdvice;

    private array $config;

    /**
     * @param \muyomu\aop\advice\BeforeReturnAdvice $beforeReturnAdvice
     * @param array $config
     */
    public function __construct(\muyomu\aop\advice\BeforeReturnAdvice $beforeReturnAdvice, array $config = array())
    {
        $this->beforeReturnAdvice = $beforeReturnAdvice;

        $this->config = $config;
    }

    /**
     * @return \muyomu\aop\advice\BeforeReturnAdvice
     * @throws ReflectionException
     */
    public function getInstance(): \muyomu\aop\advice\BeforeReturnAdvice
    {
        $reflectionClass = new ReflectionClass($this->beforeReturnAdvice);
        return $reflectionClass->newInstance();
    }

    /**
     * @return array
     */
    public function getConfig():array{
        return $this->config;
    }
}