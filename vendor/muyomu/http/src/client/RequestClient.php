<?php

namespace muyomu\http\client;

interface RequestClient
{
    public function getRequestMethod():string;

    public function getURL():string;

    public function getRemoteHost():string;

    public function setAttribute(string $key,mixed $value):bool;

    public function getAttribute(string $key):mixed;
}