<?php

namespace muyomu\executor\config;

use muyomu\config\annotation\Configuration;
use muyomu\config\GenericConfig;

#[Configuration("config_executor")]
class ExecutorDefaultConfig extends GenericConfig
{
    protected string $configClass = self::class;

    protected array $configData = [
        "autoInject"=>false
    ];
}