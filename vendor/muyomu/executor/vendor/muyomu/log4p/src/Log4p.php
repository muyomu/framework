<?php

namespace muyomu\log4p;

use muyomu\log4p\client\LogClient;
use muyomu\log4p\utility\LogUtility;

class Log4p implements LogClient
{
    /**
     * @param string $className
     * @param string $method
     * @param int $line
     * @param string $message
     * @return void
     */
    public static function framework_log_error(string $className,string $method,int $line,string $message):void{

        $date = LogUtility::getData();

        $log = fopen($GLOBALS["super_config"]["logDir"].date("Ymd").".log","a+");

        if (!$log) {

            $log = fopen("../log/" . date("Ymd") . ".log", "a+");
        }

        fputs($log,"[$date] [ERROR]:    ".$className.":".$method.":  "."<$line>". "   $message"."\r\n");

        fclose($log);
    }

    /**
     * @param string $className
     * @param string $method
     * @param int $line
     * @param string $message
     * @return void
     */
    public static function framework_log_warn(string $className, string $method,int $line, string $message):void{

        $date = LogUtility::getData();

        $log = fopen($GLOBALS["super_config"]["logDir"].date("Ymd").".log","a+");

        if (!$log) {

            $log = fopen("../log/" . date("Ymd") . ".log", "a+");
        }

        fputs($log,"[$date] [WARN]:    ".$className.":".$method.": "."<$line>". "   $message"."\r\n");

        fclose($log);
    }

    /**
     * @param string $item
     * @param mixed $message
     * @return void
     */
    public static function framework_log_info(string $item, mixed $message):void{

        $date = LogUtility::getData();

        $log = fopen($GLOBALS["super_config"]["logDir"].date("Ymd").".log","a+");

        if (!$log) {

            $log = fopen("../log/" . date("Ymd") . ".log", "a+");
        }

        fputs($log,"[$date] [INFO]:    ".$item." : ".$message."\r\n");

        fclose($log);
    }
}