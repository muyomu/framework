<?php

namespace muyomu\framework\filter;

use muyomu\filter\client\GenericFilter;
use muyomu\framework\exception\MethodNotMatch;
use muyomu\http\Request;
use muyomu\http\Response;
use muyomu\router\attribute\RuleMethod;

class RequestMethodFilter implements GenericFilter
{

    /**
     * @param Request $request
     * @param Response $response
     * @return void
     */
    public function filter(Request $request, Response $response): void
    {
        $method = $request->getRequestMethod();
        if (!($method == RuleMethod::RULE_GET->value || $method == RuleMethod::RULE_POST->value)){
            $response->doExceptionResponse(new MethodNotMatch(),405);
        }
    }
}