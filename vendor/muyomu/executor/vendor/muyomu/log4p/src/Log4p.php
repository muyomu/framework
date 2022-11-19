<?php

namespace muyomu\log4p;

use muyomu\log4p\client\LogClient;

class Log4p implements LogClient
{
    public static function muix_log_error(string $item, mixed $message):void{
        $date = date("Y-m-d H:i:s",time());
        $log = fopen("../resource/log/".date("Ymd").".log","a+");
        fputs($log,"\r\n"."[$date] [ERROR]:    ".$item." : ".$message);
    }

    public static function muix_log_warn(string $exception,string $classname,string $method):void{
        $date = date("Y-m-d H:i:s",time());
        $log = fopen("../resource/log/".date("Ymd").".log","a+");
        fputs($log,"\r\n"."[$date] [WARN]:    ".$exception.":    ".$classname.":    ".$method);
    }

    public static function muix_log_info(string $item, mixed $message):void{
        $date = date("Y-m-d H:i:s",time());
        $log = fopen("../resource/log/".date("Ymd").".log","a+");
        fputs($log,"\r\n"."[$date] [INFO]:     ".$item." : ".$message);
    }

    public static function muix_log_debug(string $item, mixed $message): void
    {
        $date = date("Y-m-d H:i:s",time());
        $log = fopen("../resource/log/".date("Ymd").".log","a+");
        fputs($log,"\r\n"."[$date] [INFO]:    ".$item." : ".$message);
    }

    public static function muix_log_fatal(string $item, mixed $message): void
    {
        $date = date("Y-m-d H:i:s",time());
        $log = fopen("../resource/log/".date("Ymd").".log","a+");
        fputs($log,"\r\n"."[$date] [INFO]:    ".$item." : ".$message);
    }

    public static function muix_log_trace(string $item, mixed $message): void
    {
        $date = date("Y-m-d H:i:s",time());
        $log = fopen("../resource/log/".date("Ymd").".log","a+");
        fputs($log,"\r\n"."[$date] [INFO]:    ".$item." : ".$message);
    }
}