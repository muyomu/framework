<?php

namespace muyomu\log4p\client;

use Exception;

interface LogClient
{
    public function muix_log_error(string $className,string $method,int $line,string $message):void;

    public function muix_log_warn(string $className, string $method, string $message):void;

    public function muix_log_info(string $item, mixed $message):void;

    public function muix_log_debug(string $varName,mixed $value):void;
}