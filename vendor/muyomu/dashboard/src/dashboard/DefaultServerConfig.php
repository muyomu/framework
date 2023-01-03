<?php

namespace muyomu\dashboard\dashboard;

use muyomu\config\annotation\Configuration;
use muyomu\config\GenericConfig;
use muyomu\dashboard\identifier\ServerConfig;

#[Configuration(ServerConfig::class)]
class DefaultServerConfig extends GenericConfig
{
    protected string $configClass = self::class;

    protected array $configData = array(
        "port"=>80
    );
}