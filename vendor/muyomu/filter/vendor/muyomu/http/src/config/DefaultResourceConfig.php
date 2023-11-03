<?php

namespace muyomu\http\config;

use muyomu\config\annotation\Configuration;
use muyomu\config\GenericConfig;

#[Configuration(DefaultResourceConfig::class)]
class DefaultResourceConfig extends GenericConfig
{
    protected string $configClass = self::class;

    protected array $configData = [
        "headers"=>[
            "Content-type"=>"application/octet-stream",
            "Accept-Ranges"=> "bytes",
            "Cache-Control"=>"no-store",
        ],
        "location"=>"../resource/"
    ];
}