<?php

namespace muyomu\dashboard\dashboard;

use muyomu\auth\MuixAuthMiddleWare;
use muyomu\config\annotation\Configuration;
use muyomu\config\GenericConfig;
use muyomu\dashboard\identifier\ApplicationConfig;

#[Configuration(ApplicationConfig::class)]
class DefaultApplicationConfig extends GenericConfig
{
    protected string $configClass = self::class;

    protected array $configData = array(
        "application"=>"muix",
        "globalMiddleWare"=>MuixAuthMiddleWare::class,
        "organization"=>true,
        "rootPath"=>"../",
        "filters"=>[]
    );
}