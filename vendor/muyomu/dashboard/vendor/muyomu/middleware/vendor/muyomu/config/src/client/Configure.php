<?php

namespace muyomu\config\client;

interface Configure
{
    public static function configure(string $module, array $configureData):void;
}