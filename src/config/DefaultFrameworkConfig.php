<?php

namespace muyomu\framework\config;

use muyomu\config\annotation\Configuration;
use muyomu\config\GenericConfig;

#[Configuration]
class DefaultFrameworkConfig extends GenericConfig
{
    protected string $configClass = self::class;

    protected array $configData = [
        "message"=>[
            "Application"=>"Muix",
            "Description"=>"Muix is a simple web framework based on php8.*",
            "Version"=>"2.0.0",
            "Notices"=>[
                "Request"=>"This Framework just support Get and Post Methods.",
                "Root"=>" / path can't be assigned.",
                "WebSite"=>"muix.muyomu.com",
                "Contact"=>"https://github.com/muyomu"
            ]
        ]
    ];
}