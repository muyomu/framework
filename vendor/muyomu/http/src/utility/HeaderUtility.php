<?php

namespace muyomu\http\utility;

class HeaderUtility
{
    /**
     * @param array $config
     * @return void
     */
    public function addAllHeaders(array $config):void{
        $keys = array_keys($config);

        foreach ($keys as $key){

            $value = $config[$key];

            $header = "$key: $value";

            header("$header");
        }
    }
}