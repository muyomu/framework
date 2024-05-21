<?php

namespace muyomu\framework\filter;

use muyomu\filter\client\GenericFilter;
use muyomu\framework\exception\ProtocolVersionSupportException;
use muyomu\http\Request;
use muyomu\http\Response;
use muyomu\log4p\Log4p;

class RequestProtocolVersionFilter implements GenericFilter
{

    public function filter(Request $request, Response $response): void
    {
        if(!($_SERVER["SERVER_PROTOCOL"] === "HTTP/1.1")){
           Log4p::framework_log_error(__CLASS__,__METHOD__,__LINE__,"The request protocol version is not supported");

           $response->doExceptionResponse(new ProtocolVersionSupportException(),200);
        }
    }
}