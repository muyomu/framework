<?php

namespace muyomu\http\client;

interface ResponseClient
{
    public function setHeader(string $header):void;

    public function doResponse(mixed $data):void;

    public function returnWhite():void;

    public function returnRaw(mixed $data):void;

    public function returnJson(array $data):void;

    public function returnBadData():void;
}