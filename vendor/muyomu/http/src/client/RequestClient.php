<?php

namespace muyomu\http\client;

interface RequestClient
{
    public function getRequestMethod():string;

    public function getRequestURI():string;

    public function getQueryString():string;

    public function getProtocol():string;

    public function getURL():string;

    public function getRemoteHost():string;

    public function getRemotePort():int;

    public function setAttribute(string $key,mixed $value):bool;

    public function getAttribute(string $key):mixed;
}