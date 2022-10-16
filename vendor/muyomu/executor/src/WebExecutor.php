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

    /**
     * @throws ReflectionException|KeyNotFond
     */
    public function webExecutor(Request $request,Response $response,string $controllerClassName, string $method): void
    {
        /*
         * 获取控制器反射类
         */
        $class = new ReflectionClass($controllerClassName);

        /*
         * 获取控制器实例并注入依赖
         */
        $instance = $class->newInstance();

        //注入request
        $request_property = $class->getProperty("request");

        /** @var TYPE_NAME $request_property */
        $request_property->setAccessible(true);
        $request_property->setValue($instance,$request);

        //注入response
        $response_property = $class->getProperty("response");

        /** @var TYPE_NAME $response_property */
        $response_property->setAccessible(true);
        $response_property->setValue($instance,$response);

        /*
         * 获取控制器处理器
         */
        $method = $class->getMethod($method);

        /*
         * prepare data
         */
        $rule = $request->getDataBase()->select("rule")->getData();


        /*
         * 执行控制器处理器
         */
        $returnData = $method->invoke($instance);

        /*
         * 处理返回数据
         */
        $response->doResponse($returnData);
    }
}