<?php

namespace muyomu\framework\config;

use muyomu\config\annotation\Configuration;
use muyomu\config\base\GenericConfig;

#[Configuration("config_application")]
class DefaultApplicationConfig extends GenericConfig
{
    protected array $configData = [
        "application"=>"muix"
    ];
}