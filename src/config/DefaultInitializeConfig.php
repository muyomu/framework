<?php

namespace muyomu\framework\config;

use muyomu\config\annotation\Configuration;
use muyomu\config\GenericConfig;

#[Configuration(DefaultInitializeConfig::class)]
class DefaultInitializeConfig extends GenericConfig
{
    protected string $configClass = self::class;

    protected array $configData = array(
        "ini"=>[],
        "ext"=>[],
        "callable"=>[]
    );
}