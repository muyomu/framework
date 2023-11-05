<?php

namespace muyomu\aop\delegate;

use Attribute;
use ReflectionClass;
use ReflectionException;

#[Attribute(Attribute::TARGET_METHOD)]
class Agency
{
    private string $agency;

    private array $config;

    /**
     * @param string $agency
     * @param array $config
     */
    public function __construct(string $agency, array $config = array())
    {
        $this->agency = $agency;

        $this->config = $config;
    }

    /**
     * @return Delegate
     * @throws ReflectionException
     */
    public function getInstance(): Delegate
    {
        $reflectionClass = new ReflectionClass($this->agency);
        return $reflectionClass->newInstance();
    }

    /**
     * @return array
     */
    public function getArg():array{
        return $this->config;
    }
}