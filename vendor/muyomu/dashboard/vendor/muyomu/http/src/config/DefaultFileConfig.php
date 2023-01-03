<?php

namespace muyomu\http\config;

use muyomu\config\annotation\Configuration;
use muyomu\config\GenericConfig;

#[Configuration("config_resource")]
class DefaultFileConfig extends GenericConfig
{
    protected string $configClass = self::class;

    protected array $configData = [
        "response_headers"=>[
            "Content-type"=>"application/octet-stream",
            "Accept-Ranges"=> "bytes",
            "Cache-Control"=>"no-store",
        ],
        "location"=>"../resource/file/"
    ];
}