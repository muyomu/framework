<?php

namespace muyomu\framework;

use Exception;
use muyomu\executor\exception\ServerException;
use muyomu\filter\FilterExecutor;
use muyomu\framework\filter\RequestMethodFilter;
use muyomu\framework\filter\RequestRootRuteFilter;
use muyomu\http\Request;
use muyomu\http\Response;
use muyomu\log4p\Log4p;
use muyomu\middleware\BaseMiddleWare;

class Framework
{
    private Request $request;

    private Response $response;

    private FilterExecutor $filterExecutor;

    public function __construct()
    {
        $this->request = new Request();
        $this->response = new Response();
        $this->filterExecutor = new FilterExecutor();
    }

    public static function main(BaseMiddleWare $middleWare):void{

        $framework = new Framework();

        $application = new CreateApp();

        $filterChain = $framework->getFilterExecutor();

        $logger = new Log4p();

        //添加过滤器
        $filterChain->addFilter(new RequestMethodFilter());
        $filterChain->addFilter(new RequestRootRuteFilter());

        //执行过滤器链
        $filterChain->doFilterChain($framework->getRequest(),$framework->getResponse());

        try {
            $application->configApplicationMiddleWare($middleWare);
            $application->run($framework->getRequest(),$framework->getResponse());
        }catch (Exception $e){
            $logger->muix_log_warn(__CLASS__,__METHOD__,__LINE__,$e->getMessage());
            $framework->getResponse()->doExceptionResponse(new ServerException(),503);
        }
    }

    /**
     * @return Request
     */
    public function getRequest(): Request
    {
        return $this->request;
    }

    /**
     * @return Response
     */
    public function getResponse(): Response
    {
        return $this->response;
    }

    /**
     * @return FilterExecutor
     */
    public function getFilterExecutor(): FilterExecutor
    {
        return $this->filterExecutor;
    }
}