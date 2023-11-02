<?php

namespace muyomu\executor;

use muyomu\executor\client\ExecutorClient;
use muyomu\executor\config\DefaultExecutorConfig;
use muyomu\executor\exception\ServerException;
use muyomu\executor\utility\ParaResolve;
use muyomu\http\Request;
use muyomu\http\Response;
use muyomu\inject\Proxy;
use ReflectionException;

class WebExecutor implements ExecutorClient
{
    private Utility $utility;

    private DefaultExecutorConfig $executorDefaultConfig;

    private Proxy $proxy;

    private ParaResolve $paraResolve;

    public function __construct(){
        $this->utility = new Utility();
        $this->executorDefaultConfig = new DefaultExecutorConfig();
        $this->proxy = new Proxy();
        $this->paraResolve = new ParaResolve();
    }

    /**
     * @throws ServerException|ReflectionException
     */
    public function webExecutor(Request $request, Response $response, string $controllerClassName, string $handle): void
    {
        /*
         * 获取控制器反射类
         */
        $class = $this->utility->getReflectionClass($response,$controllerClassName);

        /*
         * 获取控制器实例并注入依赖
         */
        $instance = $this->utility->getControllerInstance($response,$class);

        /*
         * 注入request,response
         */
        $this->utility->injectRR($request,$response,$class,$instance);

        /*
         * 自动注入依赖
         */
        if ($this->executorDefaultConfig->getOptions("autoInject")){
            $this->proxy->getProxyInstance($instance);
        }

        /*
         * 获取控制器处理器
         */
        $method = $this->utility->getControllerHandle($response,$class,$handle);

        /*
         * 执行控制器处理器
         */
        $returnData = null;
        
        try {
            $returnData = $this->utility->handleExecutor($response, $instance, $method, $this->paraResolve->resolvePara($method));
        } catch (exception\ParaMissException|ServerException|exception\UnKnownPara $e) {

        }

        /*
         * 处理返回数据
         */
        $response->doJsonResponse(200,"success",$returnData);
    }
}