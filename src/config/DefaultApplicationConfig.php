<?php

namespace muyomu\framework\config;

use muyomu\config\annotation\Configuration;
use muyomu\config\GenericConfig;

#[Configuration("config_application")]
class DefaultApplicationConfig extends GenericConfig
{
    protected string $configClass = self::class;

    protected array $configData = [
        "application"=>"muix"
    ];
}