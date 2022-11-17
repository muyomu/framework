<?php

namespace muyomu\aop\advice;

interface Client
{
    public function aopExecutor(string $targetClassName,string $targetHandleName,...$args):mixed;
}