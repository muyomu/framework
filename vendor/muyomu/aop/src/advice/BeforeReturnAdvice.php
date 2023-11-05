<?php

namespace muyomu\aop\advice;

interface BeforeReturnAdvice
{
    public function beforeReturnAdvice(array $config):void;
}