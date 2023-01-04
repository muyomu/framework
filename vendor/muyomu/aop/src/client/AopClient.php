<?php

namespace muyomu\aop\client;

interface AopClient
{
    public function aopExecutor(object $instance, string $method,array $args):mixed;
}