<?php

namespace muyomu\framework\generic;

use muyomu\http\Request;
use muyomu\http\Response;

interface Serve
{
    public function run(Request $request,Response $response):void;
}