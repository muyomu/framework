<?php

namespace muyomu\config;

class ConfigApi implements client\Configure
{

    /**
     * @param string $module
     * @param array $configureData
     * @return void
     */
    public static function configure(string $module, array $configureData): void
    {
        $GLOBALS[$module] = $configureData;
    }
}