<?php

namespace muyomu\framework\filter;

use muyomu\filter\client\GenericFilter;
use muyomu\framework\exception\MethodNotMatchException;
use muyomu\http\Request;
use muyomu\http\Response;
use muyomu\log4p\Log4p;
use muyomu\router\attribute\RuleMethod;

class RequestMethodFilter implements GenericFilter
{
    private Log4p $log4p;

    public function __construct()
    {
        $this->log4p = new Log4p();
    }

    /**
     * @param Request $request
     * @param Response $response
     * @return void
     */
    public function filter(Request $request, Response $response): void
    {
        $method = $request->getRequestMethod();
        if (!($method == RuleMethod::RULE_GET->value || $method == RuleMethod::RULE_POST->value)){
            $this->log4p->muix_log_error(__CLASS__,__METHOD__,__LINE__,"The request protocol version is not supported");
            $response->doExceptionResponse(new MethodNotMatchException(),405);
        }
    }
}