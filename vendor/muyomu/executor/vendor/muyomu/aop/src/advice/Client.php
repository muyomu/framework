<?php

namespace muyomu\aop\advice;

interface Client
{
    public function aopExecutor(string $targetClassName,string $targetHandleName,mixed $argsForAop,array $args):mixed;
}