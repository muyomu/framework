<?php

namespace muyomu\executor\config;

use muyomu\config\annotation\Configuration;
use muyomu\config\GenericConfig;

#[Configuration(ExecutorDefaultConfig::class)]
class ExecutorDefaultConfig extends GenericConfig
{
    protected string $configClass = self::class;

    protected array $configData = [
        "autoInject"=>false
    ];
}