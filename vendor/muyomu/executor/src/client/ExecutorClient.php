<?php

namespace muyomu\executor\client;

use muyomu\http\Request;
use muyomu\http\Response;

interface ExecutorClient
{
    public function webExecutor(object $application, Request $request,Response $response,string $controllerClassName,string $method):void;
}