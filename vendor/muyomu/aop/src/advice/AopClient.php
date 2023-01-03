<?php

namespace muyomu\aop\advice;

interface AopClient
{
    public function aopExecutor(object $instance, string $method,array $args):mixed;
}