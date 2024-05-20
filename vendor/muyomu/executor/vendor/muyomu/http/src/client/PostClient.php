<?php

namespace muyomu\http\client;

interface PostClient
{
    public function postPara(string $varName):mixed;
}