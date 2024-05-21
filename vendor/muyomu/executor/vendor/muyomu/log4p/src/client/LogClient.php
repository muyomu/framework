<?php

namespace muyomu\log4p\client;

interface LogClient
{
    /**
     * @param string $className
     * @param string $method
     * @param int $line
     * @param string $message
     * @return void
     * This function means that the fault can't be tackled and should be resolved by coder.
     */
    public static function framework_log_error(string $className, string $method, int $line,  string $message):void;

    /**
     * @param string $className
     * @param string $method
     * @param int $line
     * @param string $message
     * @return void
     * This function means that the fault can be tackled by default strategy, but the coder should focus on it.
     */
    public static function framework_log_warn(string $className, string $method,   int $line, string $message):void;

    /**
     * @param string $item
     * @param mixed $message
     * @return void
     * This function is used to echo the data you want to write to the log file.
     */
    public static function framework_log_info(string $item, mixed $message):void;
}