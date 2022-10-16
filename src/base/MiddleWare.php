<?php

namespace muyomu\framework\base;

use muyomu\http\Request;

interface MiddleWare
{
    public function handle(Request $request,callable $next):void;
}