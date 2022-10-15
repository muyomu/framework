<?php

namespace muyomu\framework\base;

use muyomu\framework\http\Request;
use muyomu\framework\http\Response;

abstract class Controller
{
    protected Request $request;

    protected Response $response;
}