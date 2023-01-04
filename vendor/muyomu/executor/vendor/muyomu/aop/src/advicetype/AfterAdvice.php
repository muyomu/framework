<?php

namespace muyomu\aop\advicetype;

use Attribute;

#[Attribute(Attribute::TARGET_METHOD)]
class AfterAdvice
{
    private \muyomu\aop\advice\AfterAdvice $className;


    public function __construct(\muyomu\aop\advice\AfterAdvice $className)
    {
        $this->className = $className;
    }

    /**
     * @return \muyomu\aop\advice\AfterAdvice
     */
    public function getInstance(): \muyomu\aop\advice\AfterAdvice
    {
        return $this->className;
    }
}