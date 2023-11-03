<?php

namespace muyomu\http\client;

use Exception;

interface HttpClient
{
    public function setHeader(string $field,string $content):void;

    public function reDirect(string $url):void;

    public function doExceptionResponse(Exception $exception, int $code): void;
}