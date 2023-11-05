<?php

namespace muyomu\inject\annotation;

use Attribute;
use ReflectionClass;
use ReflectionException;

#[Attribute(Attribute::TARGET_PROPERTY)]
class AutoWired
{
    private string $className;

    private array $config;

    /**
     * @param string $className
     * @param array $config
     */
    public function __construct(string $className, array $config = array())
    {
        $this->className = $className;

        $this->config = $config;
    }

    /**
     * @return object
     * @throws ReflectionException
     */
    public function getValue():object{
        $reflectionClass = new ReflectionClass($this->className);
        return $reflectionClass->newInstanceArgs($this->config);
    }
}