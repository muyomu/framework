<?php

namespace muyomu\aop\advice;

interface BeforeCatchAdvice
{
    public function beforeCatchAdvice(array $config):void;
}