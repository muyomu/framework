<?php

namespace muyomu\aop\advicetype;

use Attribute;

#[Attribute(Attribute::TARGET_METHOD)]
class BeforeCatchAdvice
{
    private \muyomu\aop\advice\BeforeCatchAdvice $className;

    public function __construct(\muyomu\aop\advice\BeforeCatchAdvice $className)
    {
        $this->className = $className;
    }

    public function getInstance(): \muyomu\aop\advice\BeforeCatchAdvice
    {
        return $this->className;
    }
}