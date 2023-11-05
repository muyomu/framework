<?php

namespace muyomu\aop\advice;

interface BeforeAdvice
{
    public function beforeAdvice(array $config):void;
}