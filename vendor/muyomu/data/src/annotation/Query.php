<?php

namespace muyomu\data\annotation;

use Attribute;

#[Attribute(Attribute::TARGET_METHOD)]
class Query
{
    private string $sql;

    public function __construct(string $sql)
    {
        $this->sql = $sql;
    }

    /**
     * @return string
     */
    public function getSql(): string
    {
        return $this->sql;
    }
}