<?php

namespace muyomu\http\client;

interface HeaderClient
{
    public function getHeader(string $key):string | null;
}