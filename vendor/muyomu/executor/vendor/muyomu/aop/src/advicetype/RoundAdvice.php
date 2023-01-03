<?php

namespace muyomu\aop\advicetype;

use Attribute;

#[Attribute(Attribute::TARGET_METHOD)]
class RoundAdvice
{
    private \muyomu\aop\advice\RoundAdvice $className;

    public function __construct(\muyomu\aop\advice\RoundAdvice $className)
    {
        $this->className = $className;
    }

    public function getInstance(): \muyomu\aop\advice\RoundAdvice
    {
        return $this->className;
    }
}