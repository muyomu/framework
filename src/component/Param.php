<?php

namespace muyomu\framework\component;

use Attribute;

#[Attribute(Attribute::TARGET_PARAMETER)]
class Param
{
    private string $dataType;

    private mixed $default;

    private bool $must;

    private string $validate;

    public function __construct(string $validate,mixed $default,bool $must=false,string $dataType="string")
    {
        $this->default = $default;
        $this->must = $must;
        $this->validate = $validate;
        $this->dataType = $dataType;
    }

    /**
     * @return mixed
     */
    public function getDefault(): mixed
    {
        return $this->default;
    }

    /**
     * @return bool
     */
    public function isMust(): bool
    {
        return $this->must;
    }

    /**
     * @return string
     */
    public function getDataType(): string
    {
        return $this->dataType;
    }

    /**
     * @return string
     */
    public function getValidate(): string
    {
        return $this->validate;
    }
}