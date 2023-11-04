<?php

namespace muyomu\framework\config;

use muyomu\config\annotation\Configuration;
use muyomu\config\GenericConfig;

#[Configuration(DefaultApplicationConfig::class)]
class DefaultApplicationConfig extends GenericConfig
{
    protected string $configClass = self::class;

    protected array $configData = [
        "organization"=>true,
        "filters"=>[]
    ];
}