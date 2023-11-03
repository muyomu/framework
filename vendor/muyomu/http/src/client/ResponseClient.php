<?php

namespace muyomu\http\client;

interface ResponseClient
{
    public function doPlainResponse(string $fileName, bool $display = true):void;

    public function doJsonResponse(string $fileName, bool $display = true):void;

    public function doXmlResponse(string $fileName, bool $display = true):void;

    public function doImageResponse(string $fileName, bool $display = true):void;

    public function doAudioResponse(string $fileName, bool $display = true):void;

    public function doVideoResponse(string $fileName, bool $display = true):void;

    public function doResourceResponse(string $fileName):void;

    public function doViewResponse(string $fileName):void;
}