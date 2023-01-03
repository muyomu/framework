<?php

namespace muyomu\config\annotation;

use Attribute;

#[Attribute(Attribute::TARGET_CLASS)]
class Configuration
{
    private string $configField;

    public function __construct(string $configField = '')
    {
        $this->configField = $configField;
    }

    /**
     * @return string
     */
    public function getConfigField(): string
    {
        return $this->configField;
    }
}