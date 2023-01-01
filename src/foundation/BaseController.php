<?php

namespace muyomu\framework\foundation;


use muyomu\http\Request;
use muyomu\http\Response;

abstract class BaseController
{
    protected Request $request;

    protected Response $response;
}