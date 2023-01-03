<?php

namespace muyomu\config;

class ConfigApi implements client\Configure
{

    public static function configure(string $module, array $configureData): void
    {
        $GLOBALS[$module] = $configureData;
    }
}