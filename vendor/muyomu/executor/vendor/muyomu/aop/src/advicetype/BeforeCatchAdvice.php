<?php

namespace muyomu\aop\advicetype;

use Attribute;
use ReflectionClass;
use ReflectionException;

#[Attribute(Attribute::TARGET_METHOD)]
class BeforeCatchAdvice
{
    private \muyomu\aop\advice\BeforeCatchAdvice $beforeCatchAdvice;

    private array $config;

    /**
     * @param \muyomu\aop\advice\BeforeCatchAdvice $beforeCatchAdvice
     * @param array $config
     */
    public function __construct(\muyomu\aop\advice\BeforeCatchAdvice $beforeCatchAdvice, array $config = array())
    {
        $this->beforeCatchAdvice= $beforeCatchAdvice;

        $this->config = $config;
    }

    /**
     * @return \muyomu\aop\advice\BeforeCatchAdvice
     * @throws ReflectionException
     */
    public function getInstance(): \muyomu\aop\advice\BeforeCatchAdvice
    {
        $reflectionClass = new ReflectionClass($this->beforeCatchAdvice);
        return $reflectionClass->newInstance();
    }

    /**
     * @return array
     */
    public function getConfig():array{
        return $this->config;
    }
}