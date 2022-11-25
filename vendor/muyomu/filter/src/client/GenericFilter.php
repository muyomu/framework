<?php

namespace muyomu\filter\client;

use muyomu\http\Request;
use muyomu\http\Response;

interface GenericFilter
{
    public function filter(Request $request,Response $response):void;
}