<?php

namespace muyomu\aop\advice;

use ReflectionMethod;

interface FrameWork
{
    public function aopExecutor(object $instance, ReflectionMethod $method,mixed $args):mixed;
}