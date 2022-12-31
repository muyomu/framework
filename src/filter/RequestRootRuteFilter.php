<?php

namespace muyomu\framework\filter;

use muyomu\filter\client\GenericFilter;
use muyomu\framework\config\DefaultFrameworkConfig;
use muyomu\http\Request;
use muyomu\http\Response;
use muyomu\log4p\Log4p;

class RequestRootRuteFilter implements GenericFilter
{
    private DefaultFrameworkConfig $defaultFrameworkConfig;

    private Log4p $log4p;

    public function __construct()
    {
        $this->defaultFrameworkConfig = new DefaultFrameworkConfig;
        $this->log4p = new Log4p();
    }

    /**
     * @param Request $request
     * @param Response $response
     * @return void
     */
    public function filter(Request $request, Response $response): void
    {
        $uri = $request->getURL();
        if ($uri === "/"){
            $this->log4p->muix_log_error(__CLASS__,__METHOD__,__LINE__,"The request protocol version is not supported");
            $response->doDataResponse($this->defaultFrameworkConfig->getOptions("message"),200);
        }
    }
}