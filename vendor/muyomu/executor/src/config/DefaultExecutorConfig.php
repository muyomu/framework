<?php

namespace muyomu\executor\config;

use muyomu\config\annotation\Configuration;
use muyomu\config\GenericConfig;

#[Configuration(DefaultExecutorConfig::class)]
class DefaultExecutorConfig extends GenericConfig
{
    protected string $configClass = self::class;

    protected array $configData = [
        "autoInject"=>false
    ];
}