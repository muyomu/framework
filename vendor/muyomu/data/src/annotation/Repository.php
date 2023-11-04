<?php

namespace muyomu\data\annotation;

use Attribute;

#[Attribute(Attribute::TARGET_CLASS)]
class Repository
{
    private string $DataSource;

    public function __construct(string $DataSource)
    {
        $this->DataSource = $DataSource;
    }

    /**
     * @return string
     */
    public function getDataSource(): string
    {
        return $this->DataSource;
    }
}