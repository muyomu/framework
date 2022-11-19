<?php

namespace muyomu\log4p\client;

interface LogClient
{
    public static function muix_log_warn(string $exception,string $classname,string $method):void;

    public static function muix_log_error(string $item, mixed $message):void;

    public static function muix_log_info(string $item, mixed $message):void;

    public static function muix_log_debug(string $item, mixed $message):void;

    public static function muix_log_fatal(string $item, mixed $message):void;

    public static function muix_log_trace(string $item, mixed $message):void;
}