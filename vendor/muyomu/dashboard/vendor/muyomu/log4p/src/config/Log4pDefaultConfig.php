<?php

namespace muyomu\log4p\config;

use muyomu\config\annotation\Configuration;
use muyomu\config\GenericConfig;

#[Configuration("config_log4p")]
class Log4pDefaultConfig extends GenericConfig
{
    protected string $configClass = self::class;

    protected array $configData = [
        "log_location"=>"../log/"
    ];
}