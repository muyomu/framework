<?php

namespace muyomu\aop\advicetype;

use Attribute;

#[Attribute(Attribute::TARGET_METHOD)]
class HystrixAdvice
{
    private \muyomu\aop\advice\HystrixAdvice $HystrixClassName;

    public function __construct(\muyomu\aop\advice\HystrixAdvice $HystrixClassName)
    {
        $this->HystrixClassName = $HystrixClassName;
    }

    /**
     * @return \muyomu\aop\advice\HystrixAdvice
     */
    public function getInstance(): \muyomu\aop\advice\HystrixAdvice
    {
        return $this->HystrixClassName;
    }
}