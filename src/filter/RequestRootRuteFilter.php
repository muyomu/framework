<?php

namespace muyomu\framework\filter;

use muyomu\filter\client\GenericFilter;
use muyomu\framework\config\DefaultFrameworkConfig;
use muyomu\http\Request;
use muyomu\http\Response;

class RequestRootRuteFilter implements GenericFilter
{
    private DefaultFrameworkConfig $defaultFrameworkConfig;

    public function __construct()
    {
        $this->defaultFrameworkConfig = new DefaultFrameworkConfig;
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
            $response->doDataResponse($this->defaultFrameworkConfig->getOptions("message"),200);
        }
    }
}