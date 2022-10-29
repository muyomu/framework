<?php

namespace muyomu\framework\component;

use Attribute;

#[Attribute(Attribute::TARGET_PARAMETER)]
class Param
{
    private string $validate;

    public function __construct(string $validate)
    {
        $this->validate = $validate;
    }

    /**
     * @return string
     */
    public function getValidate(): string
    {
        return $this->validate;
    }
}