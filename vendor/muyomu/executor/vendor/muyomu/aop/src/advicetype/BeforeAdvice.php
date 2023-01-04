<?php

namespace muyomu\aop\advicetype;

use Attribute;

#[Attribute(Attribute::TARGET_METHOD)]
class BeforeAdvice
{
    private \muyomu\aop\advice\BeforeAdvice $className;

    public function __construct(\muyomu\aop\advice\BeforeAdvice $className)
    {
        $this->className = $className;
    }

    /**
     * @return \muyomu\aop\advice\BeforeAdvice
     */
    public function getInstance(): \muyomu\aop\advice\BeforeAdvice
    {
        return $this->className;
    }
}