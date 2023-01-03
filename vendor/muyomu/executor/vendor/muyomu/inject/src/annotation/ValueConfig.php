<?php

namespace muyomu\inject\annotation;

use Attribute;

#[Attribute(Attribute::TARGET_PROPERTY)]
class ValueConfig
{
    private string $field;

    private string $configClass;

    public function __construct(string $field,string $configClass)
    {
        $this->configClass = $configClass;
        $this->field = $field;
    }

    /**
     * @return string
     */
    public function getValue(): mixed
    {
        return $this->configClass;
    }
}