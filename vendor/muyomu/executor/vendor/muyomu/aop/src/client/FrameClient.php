<?php

namespace muyomu\aop\client;

use ReflectionMethod;

interface FrameClient
{
    public function aopExecutor(object $instance, ReflectionMethod $method, array $args):mixed;
}