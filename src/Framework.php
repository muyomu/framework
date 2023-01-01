<?php

namespace muyomu\framework;

use Exception;
use muyomu\executor\exception\ServerException;
use muyomu\filter\client\GenericFilter;
use muyomu\filter\FilterExecutor;
use muyomu\framework\config\DefaultApplicationConfig;
use muyomu\framework\filter\RequestMethodFilter;
use muyomu\framework\filter\RequestRootRuteFilter;
use muyomu\framework\system\System;
use muyomu\http\message\Message;
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

    public function __construct()
    {
        $this->request = new Request();
        $this->response = new Response();
        $this->filterExecutor = new FilterExecutor();
    }

    /**
     * @return void
     */
    public static function main():void{
        //加载系统配置
        System::system();

        //logger
        $logger = new Log4p();

        //framework
        $framework = new Framework();

        //application
        $application = new CreateApp();

        //config
        $config = new DefaultApplicationConfig();

        //获取中间件实例
        try {
            $middleWare = new ReflectionClass($config->getOptions("globalMiddleWare"));
        }catch (ReflectionException $exception){
            $logger->muix_log_warn(__CLASS__,__METHOD__,__LINE__,$exception->getMessage());
            $framework->getResponse()->doExceptionResponse(new ServerException(),503);
        }

        //配置全局中间件
        try {
            $application->configApplicationMiddleWare($middleWare->newInstance());
        }catch (Exception $exception){
            $logger->muix_log_warn(__CLASS__,__METHOD__,__LINE__,$exception->getMessage());
            $framework->getResponse()->doExceptionResponse(new ServerException(),503);
        }

        //获取过滤器处理器
        $filterChain = $framework->getFilterExecutor();

        //添加系统过滤器
        $filterChain->addFilter(new RequestMethodFilter());
        $filterChain->addFilter(new RequestRootRuteFilter());

        //添加用户过滤器
        $framework->loadUserFilters($filterChain,$config->getOptions("filters"));

        //执行过滤器链
        $filterChain->doFilterChain($framework->getRequest(),$framework->getResponse());

        //执行web请求
        try {
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

    /**
     * @param FilterExecutor $filterChain
     * @param array $userFilters
     * @return void
     */
    public function loadUserFilters(FilterExecutor $filterChain,array $userFilters):void{
        foreach ($userFilters as $filter){
            if ($filter instanceof GenericFilter){
                $filterChain->addFilter($filter);
            }
        }
    }
}