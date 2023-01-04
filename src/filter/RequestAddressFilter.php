<?php

namespace muyomu\framework\filter;

use muyomu\filter\client\GenericFilter;
use muyomu\http\Request;
use muyomu\http\Response;

class RequestAddressFilter implements GenericFilter
{

    public function filter(Request $request, Response $response): void
    {
    }
}