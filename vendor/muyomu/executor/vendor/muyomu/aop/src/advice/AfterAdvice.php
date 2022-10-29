<?php

namespace muyomu\aop\advice;

interface AfterAdvice
{
    public function afterAdviceHandle(mixed $argv):void;
}