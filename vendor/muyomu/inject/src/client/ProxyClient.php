<?php

namespace muyomu\inject\client;

interface ProxyClient
{
    /**
     * @param mixed $classOrInstance
     * @return object
     * This function is used to get an instance injected with it's marked annotation.
     */
    public function getProxyInstance(mixed $classOrInstance):object;
}