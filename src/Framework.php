<?php

namespace muyomu\framework;

use muyomu\executor\exception\ServerException;
use muyomu\filter\client\GenericFilter;
use muyomu\filter\FilterExecutor;
use muyomu\framework\config\DefaultApplicationConfig;
use muyomu\framework\exception\RequestMethodNotMatchRoutException;
use muyomu\framework\filter\RequestMethodFilter;
use muyomu\framework\filter\RequestProtocolVersionFilter;
use muyomu\framework\system\System;
use muyomu\http\Request;
use muyomu\http\Response;
use muyomu\log4p\Log4p;
use ReflectionClass;
use ReflectionException;

class Framework
{
    private Request $request;

    private Response $response;

    private FilterExecutor $filterExecutor;

    private Log4p $logger;

    public function __construct()
    {
        $this->request = new Request();

        $this->response = new Response();

        $this->filterExecutor = new FilterExecutor();

        $this->logger = new Log4p();
    }

    /**
     * @return void
     * @throws ServerException|exception\RequestMethodNotMatchRoutException
     * @throws RequestMethodNotMatchRoutException
     * @throws ReflectionException
     */
    public static function main():void{

        //framework
        $framework = new Framework();

        //加载系统配置
        System::system($framework->getResponse());

        //application
        $application = new Runtime($framework->logger);

        //config
        $config = new DefaultApplicationConfig();

        //获取过滤器处理器
        $filterChain = $framework->getFilterExecutor();

        //添加系统过滤器
        $filterChain->addFilter(new RequestMethodFilter());
        $filterChain->addFilter(new RequestProtocolVersionFilter());

        //添加用户过滤器
        $framework->loadUserFilters($filterChain,$config->getOptions("filters"));

        //执行过滤器链
        $filterChain->doFilterChain($framework->getRequest(),$framework->getResponse());

        //执行web请求
        $application->run($framework->getRequest(),$framework->getResponse());
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

    /**
     * @param FilterExecutor $filterChain
     * @param array $userFilters
     * @return void
     * @throws ReflectionException
     */
    public function loadUserFilters(FilterExecutor $filterChain, array $userFilters):void{

        foreach ($userFilters as $filter => $config){

            $reflectionClass = new ReflectionClass($filter);

            $reflectionInstance = $reflectionClass->newInstanceArgs($config);

            if ($reflectionInstance instanceof GenericFilter){

                $filterChain->addFilter($reflectionInstance);
            }
        }
    }
}