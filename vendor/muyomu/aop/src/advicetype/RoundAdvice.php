<?php

namespace muyomu\aop\advicetype;

use Attribute;
use ReflectionClass;
use ReflectionException;

#[Attribute(Attribute::TARGET_METHOD)]
class RoundAdvice
{
    private \muyomu\aop\advice\RoundAdvice $roundAdvice;

    private array $config;

    /**
     * @param \muyomu\aop\advice\RoundAdvice $roundAdvice
     * @param array $config
     */
    public function __construct(\muyomu\aop\advice\RoundAdvice $roundAdvice, array $config = array())
    {
        $this->roundAdvice = $roundAdvice;

        $this->config = $config;
    }

    /**
     * @return \muyomu\aop\advice\RoundAdvice
     * @throws ReflectionException
     */
    public function getInstance(): \muyomu\aop\advice\RoundAdvice
    {
        $reflectionClass = new ReflectionClass($this->roundAdvice);
        return $reflectionClass->newInstance();
    }

    /**
     * @return array
     */
    public function getConfig():array{
        return $this->config;
    }
}