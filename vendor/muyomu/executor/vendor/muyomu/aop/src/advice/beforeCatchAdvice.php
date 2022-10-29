<?php

namespace muyomu\aop\advice;

interface beforeCatchAdvice
{
    public function beforeCatchAdviceHandle(mixed $argv):void;
}