<?php

namespace muyomu\framework\filter;

use muyomu\config\ConfigParser;
use muyomu\filter\client\GenericFilter;
use muyomu\framework\config\DefaultFrameworkConfig;
use muyomu\http\Request;
use muyomu\http\Response;

class RequestRootRuteFilter implements GenericFilter
{

    /**
     * @param Request $request
     * @param Response $response
     * @return void
     */
    public function filter(Request $request, Response $response): void
    {
        $parser = new ConfigParser();
        $uri = $request->getURL();
        if ($uri === "/"){
            $data = $parser->getConfigData(DefaultFrameworkConfig::class);
            $response->doDataResponse($data,200);
        }
    }
}