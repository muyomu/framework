<?php

namespace muyomu\aop\advicetype;

use Attribute;

#[Attribute(Attribute::TARGET_METHOD)]
class Hystrix
{
    private string $HystrixClassName;

    public function __construct(string $HystrixClassName)
    {
        $this->HystrixClassName = $HystrixClassName;
    }

    /**
     * @return string
     */
    public function getHystrixClassName(): string
    {
        return $this->HystrixClassName;
    }
}