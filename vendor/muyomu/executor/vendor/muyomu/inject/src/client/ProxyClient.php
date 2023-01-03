<?php

namespace muyomu\inject\client;

interface ProxyClient
{
    public function getProxyInstance(mixed $classOrInstance):object;
}