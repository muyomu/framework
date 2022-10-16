<?php

namespace muyomu\framework\base;

use muyomu\framework\CreateApp;
use muyomu\http\Request;

interface BaseMiddleWare
{
    public function handle(CreateApp $application,Request $request,callable $next):void;
}