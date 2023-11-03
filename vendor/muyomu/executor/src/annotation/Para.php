<?php

namespace muyomu\executor\annotation;

use Attribute;

#[Attribute(Attribute::TARGET_CLASS)]
class Para
{
    private string $name;

    private string $range;

    public function __construct(string $name, string $range){
        $this->name = $name;

        $this->range = $range;
    }

    public function getName():string{
        return $this->name;
    }

    public function getRange():string{
        return $this->range;
    }
}