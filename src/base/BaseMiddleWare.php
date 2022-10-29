<?php

namespace muyomu\framework\base;

use muyomu\framework\CreateApp;
use muyomu\http\Request;
use muyomu\http\Response;

interface BaseMiddleWare
{
    public function handle(Request $request,Response $response):void;
}