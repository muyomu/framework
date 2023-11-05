<?php

namespace muyomu\framework\system;

use Exception;
use muyomu\framework\config\DefaultInitializeConfig;
use muyomu\framework\exception\EnvConfigException;
use muyomu\framework\format\ExceptionFormat;
use muyomu\http\Response;
use muyomu\log4p\Log4p;

class System
{
    public static function system(Response $response):void{
        //global exception handle
        set_exception_handler(function (Exception $exception) {

            header("Content-Type: text/json;charset=UTF-8");

            $format = new ExceptionFormat(500,"ServerError","Describe Exception Message",$exception->getMessage());

            echo json_encode($format->format(), JSON_UNESCAPED_UNICODE);
        });

        //global error handle
        set_error_handler(function ($errno) {

            header("Content-Type: text/json;charset=UTF-8");

            $format = new ExceptionFormat(500,"ServerError","Describe Error Message",$errno);

            echo json_encode($format->format(), JSON_UNESCAPED_UNICODE);
        });

        $logger = new Log4p();

        $ini = new DefaultInitializeConfig();

        //set ini
        $iniArray = $ini->getOptions("ini");

        $keys = array_keys($iniArray);

        foreach ( $keys as $key){

            $k = ini_set($key,$iniArray[$key]);

            if (!$k){
                $logger->muix_log_info("ini set","failed to set {$key} env");
            }
        }

        //load ext
        $extArray = $ini->getOptions("ext");

        foreach ($extArray as $item){

            $result = extension_loaded($item);

            if (!$result){

                $logger->muix_log_info("ext load","{$item} should be set to load but not be loaded!");

                $response->doExceptionResponse(new EnvConfigException(),500);
            }
        }

        //callable function
        $callableArray = $ini->getOptions("callable");

        foreach ($callableArray as $item){
            $item();
        }
    }
}