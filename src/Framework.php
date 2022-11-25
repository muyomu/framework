<?php

namespace muyomu\framework;

use Exception;
use muyomu\filter\FilterExecutor;
use muyomu\framework\base\BaseMiddleWare;
use muyomu\framework\filter\RequestMethodFilter;
use muyomu\http\Request;
use muyomu\http\Response;
use muyomu\log4p\Log4p;

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

        $filterChain->addFilter(new RequestMethodFilter());

        try {
            $application->configApplicationMiddleWare($middleWare);
            $application->run($framework->getRequest(),$framework->getResponse());
        }catch (Exception $e){
            Log4p::muix_log_warn($e::class,__CLASS__,__METHOD__);
            die();
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