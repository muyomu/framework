<?php

namespace muyomu\framework\plugin;

use muyomu\http\Request;
use muyomu\http\Response;

interface Plugin
{
    public function plugin(Request $request,Response $response):void;
}