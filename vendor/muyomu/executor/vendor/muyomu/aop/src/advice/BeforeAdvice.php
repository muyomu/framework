<?php

namespace muyomu\aop\advice;

interface BeforeAdvice
{
    public function beforeAdviceHandle(mixed $argv):void;
}