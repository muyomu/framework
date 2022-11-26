<?php

namespace muyomu\framework\config;

use muyomu\config\annotation\Configuration;
use muyomu\config\base\GenericConfig;

#[Configuration]
class DefaultFrameworkConfig extends GenericConfig
{
    protected array $configData = [
        "Application"=>"Muix",
        "Describe"=>"Muix ",
        "Version"=>"2.0.0",
        "Notices"=>[
            "Request"=>"This Framework just support Get and Post Methods.",
            "Root"=>" / path can't be assigned.",
            "WebSite"=>"muix.muyomu.com",
            "Contact"=>"https://github.com/muyomu"
        ]
    ];
}