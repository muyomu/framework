<?php

namespace muyomu\aop\advicetype;

use Attribute;

#[Attribute(Attribute::TARGET_METHOD)]
class BeforeAdvice
{
    private string $adviceClassName;

    public function __construct(string $adviceClassName)
    {
        $this->adviceClassName = $adviceClassName;
    }

    /**
     * @return string
     */
    public function getAdviceClassName(): string
    {
        return $this->adviceClassName;
    }
}