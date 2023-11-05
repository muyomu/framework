<?php

namespace muyomu\aop\delegate;

interface Delegate
{
    public function delegateAdvice(array $config):mixed;
}