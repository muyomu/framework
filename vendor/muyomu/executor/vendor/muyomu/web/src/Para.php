<?php

namespace muyomu\web;

use Attribute;

#[Attribute(Attribute::TARGET_PARAMETER)]
class Para
{
    private string $paraName;

    private string $range;

    public function __construct(string $name,string $range)
    {
        $this->paraName = $name;
        $this->range = $range;
    }

    public function getName():string{
        return $this->paraName;
    }

    public function getRange():string{
        return $this->range;
    }
}