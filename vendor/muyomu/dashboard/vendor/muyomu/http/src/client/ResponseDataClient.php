<?php

namespace muyomu\http\client;

interface ResponseDataClient
{
    public function returnWhite():void;

    public function returnRaw(mixed $data):void;

    public function returnJson(array $data):void;

    public function returnBadData():void;
}