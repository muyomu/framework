<?php

namespace muyomu\inject\annotation;

use Attribute;

#[Attribute(Attribute::TARGET_PROPERTY)]
class AutoWired
{
    private string $className;

    public function __construct(string $className)
    {
        $this->className = $className;
    }

    public function getValue():string{
        return $this->className;
    }
}