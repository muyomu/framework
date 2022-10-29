<?php

namespace muyomu\executor;

use muyomu\database\exception\KeyNotFond;
use muyomu\executor\client\ExecutorClient;
use muyomu\http\Request;
use muyomu\http\Response;
use ReflectionClass;
use ReflectionException;

class WebExecutor implements ExecutorClient
{
    public function webExecutor(Request $request,Response $response,string $controllerClassName, string $handle): void
    {
        /*
         * 获取控制器反射类
         */
        $class = null;
        try {
            $class = new ReflectionClass($controllerClassName);
        }catch (ReflectionException $exception){

        }

        /*
         * 获取控制器实例并注入依赖
         */
        $instance = null;
        try {
            $instance = $class->newInstance();
        }catch (ReflectionException $exception){

        }

        //注入request
        $request_property = null;
        try {
            $request_property = $class->getProperty("request");
        }
        catch (ReflectionException $e) {

        }
        /** @var TYPE_NAME $request_property */
        $request_property->setAccessible(true);
        $request_property->setValue($instance,$request);



        //注入response
        $response_property = null;
        try {
            $response_property = $class->getProperty("response");
        }catch (ReflectionException $e) {

        }
        /** @var TYPE_NAME $response_property */
        $response_property->setAccessible(true);
        $response_property->setValue($instance,$response);


        /*
         * 获取控制器处理器
         */
        try {
            $method = $class->getMethod($handle);
        }catch (ReflectionException $e) {

        }

        /*
         * prepare data
         */
        $rule = null;
        try {
            $rule = $request->getDbClient()->select("rule")->getData();
        }catch (KeyNotFond $e) {

        }


        /*
         * 执行控制器处理器
         */
        $returnData = null;
        try {
            $returnData = $method->invoke($instance,$rule->getPathPara());
        }catch (ReflectionException $e) {

        }

        /*
         * 处理返回数据
         */
        $response->doResponse($returnData);
    }
}