<?php

namespace muyomu\executor;

use muyomu\aop\FrameWorkClient;
use muyomu\executor\client\ExecutorClient;
use muyomu\http\Request;
use muyomu\http\Response;
use muyomu\log4p\Log4p;
use ReflectionClass;
use ReflectionException;

class WebExecutor implements ExecutorClient
{
    private FrameWorkClient $frameWorkClient;

    public function __construct(){
        $this->frameWorkClient = new FrameWorkClient();
    }

    public function webExecutor(Request $request,Response $response,string $controllerClassName, string $handle): void
    {
        /*
         * 获取控制器反射类
         */
        try {
            $class = new ReflectionClass($controllerClassName);
        }catch (ReflectionException $exception){
            Log4p::muix_log_warn($exception->getMessage(),__CLASS__,__METHOD__);
            http_header_template();
            $response->setHeader($GLOBALS['http_code'][504]);
            die();
        }

        /*
         * 获取控制器实例并注入依赖
         */
        try {
            $instance = $class->newInstance();
        }catch (ReflectionException $exception){
            Log4p::muix_log_warn($exception->getMessage(),__CLASS__,__METHOD__);
            http_header_template();
            $response->setHeader($GLOBALS['http_code'][504]);
            die();
        }

        //注入request
        try {
            $request_property = $class->getProperty("request");
            $request_property->setAccessible(true);
            $request_property->setValue($instance,$request);
        }
        catch (ReflectionException $exception) {
            Log4p::muix_log_warn($exception->getMessage(),__CLASS__,__METHOD__);
            http_header_template();
            $response->setHeader($GLOBALS['http_code'][504]);
            die();
        }



        //注入response
        try {
            $response_property = $class->getProperty("response");
            $response_property->setAccessible(true);
            $response_property->setValue($instance,$response);
        }catch (ReflectionException $exception) {
            Log4p::muix_log_warn($exception->getMessage(),__CLASS__,__METHOD__);
            http_header_template();
            $response->setHeader($GLOBALS['http_code'][504]);
            die();
        }


        /*
         * 获取控制器处理器
         */
        try {
            $method = $class->getMethod($handle);
        }catch (ReflectionException $exception) {
            Log4p::muix_log_warn($exception->getMessage(),__CLASS__,__METHOD__);
            http_header_template();
            $response->setHeader($GLOBALS['http_code'][504]);
            die();
        }

        /*
         * prepare data
         */
        $rule = $request->getDbClient()->select("rule")->getData();


        /*
         * 执行控制器处理器
         */
        try {
            $returnData = $this->frameWorkClient->aopExecutor($instance,$method,$rule->getPathPara());
        }catch (ReflectionException $exception) {
            Log4p::muix_log_warn($exception->getMessage(),__CLASS__,__METHOD__);
            http_header_template();
            $response->setHeader($GLOBALS['http_code'][505]);
            die();
        }

        /*
         * 处理返回数据
         */
        $response->doResponse($returnData);
    }
}