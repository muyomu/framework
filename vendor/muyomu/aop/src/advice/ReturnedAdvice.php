<?php

namespace muyomu\aop\advice;

interface ReturnedAdvice
{
    public function ReturnedAdviceHandle(mixed $argv):void;
}