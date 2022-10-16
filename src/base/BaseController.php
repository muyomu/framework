<?php

namespace muyomu\framework\base;


use muyomu\http\Request;
use muyomu\http\Response;

abstract class BaseController
{
    protected Request $request;

    protected Response $response;
}