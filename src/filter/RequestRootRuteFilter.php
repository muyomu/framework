<?php

namespace muyomu\framework\filter;

use muyomu\config\ConfigParser;
use muyomu\config\exception\FieldConfigException;
use muyomu\filter\client\GenericFilter;
use muyomu\framework\config\DefaultFrameworkConfig;
use muyomu\http\Request;
use muyomu\http\Response;

class RequestRootRuteFilter implements GenericFilter
{

    /**
     * @throws FieldConfigException
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