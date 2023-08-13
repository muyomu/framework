<?php

namespace muyomu\http\client;

use Exception;

interface ResponseClient
{
    public function setHeader(string $field,string $content):void;

    public function doJsonResponse(int $code,string $status,mixed $data):void;

    public function doFileResponse(string $file):void;

    public function doExceptionResponse(Exception $exception, int $code,):void;

    public function reDirect(string $url):void;
}