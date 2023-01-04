<?php

namespace muyomu\aop\advicetype;

use Attribute;

#[Attribute(Attribute::TARGET_METHOD)]
class BeforeReturnAdvice
{
    private \muyomu\aop\advice\BeforeReturnAdvice $className;

    public function __construct(\muyomu\aop\advice\BeforeReturnAdvice $className)
    {
        $this->className = $className;
    }

    /**
     * @return \muyomu\aop\advice\BeforeReturnAdvice
     */
    public function getInstance(): \muyomu\aop\advice\BeforeReturnAdvice
    {
        return $this->className;
    }
}