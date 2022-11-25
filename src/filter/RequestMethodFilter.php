<?php

namespace muyomu\framework\filter;

use muyomu\filter\client\GenericFilter;
use muyomu\http\Request;
use muyomu\http\Response;

class RequestMethodFilter implements GenericFilter
{

    public function filter(Request $request, Response $response): void
    {
        $method = $request->getRequestMethod();
    }
}