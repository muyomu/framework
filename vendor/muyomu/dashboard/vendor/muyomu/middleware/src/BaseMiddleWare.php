<?php

namespace muyomu\middleware;

use muyomu\http\Request;
use muyomu\http\Response;

interface BaseMiddleWare
{
    public function handle(Request $request,Response $response):void;
}