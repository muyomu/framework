<?php

namespace muyomu\data\config;

use muyomu\config\annotation\Configuration;
use muyomu\config\GenericConfig;

#[Configuration(DataSourceConfig::class)]
class DataSourceConfig extends GenericConfig
{
    protected string $configClass = self::class;

    protected array $configData = array(
        "pool"=>[
            "default"=>[
                "hostname"=>"localhost",
                "port"=>3306,
                "database"=>"system",
                "user"=>[
                    "username"=>"root",
                    "password"=>"123456"
                ],
                "parameters"=>[

                ]
            ]
        ],
        "pageNum"=>10
    );
}