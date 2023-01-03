<?php

namespace muyomu\http\client;

use Exception;

interface ResponseClient
{
    public function setHeader(string $field,string $content):void;

    public function doDataResponse(mixed $data, int $code):void;

    public function doExceptionResponse(Exception $exception, int $code,):void;

    public function doFileResponse(string $file):void;

    public function doCustomizeResponse(mixed $data,int $code, array $headerConfig = array()):void;
}