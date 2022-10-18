<?php

namespace muyomu\http\client;

interface GetClient
{
    public function getPara(string $varName):mixed;
}