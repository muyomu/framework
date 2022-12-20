<?php

namespace muyomu\executor;

use JetBrains\PhpStorm\NoReturn;
use muyomu\executor\client\ExecutorClient;
use muyomu\executor\config\ExecutorDefaultConfig;
use muyomu\http\Request;
use muyomu\http\Response;
use muyomu\inject\Proxy;

class WebExecutor implements ExecutorClient
{
    private Utility $utility;

    private ExecutorDefaultConfig $executorDefaultConfig;

    private Proxy $proxy;

    public function __construct(){
        $this->utility = new Utility();
        $this->executorDefaultConfig = new ExecutorDefaultConfig();
        $this->proxy = new Proxy();
    }

    #[NoReturn] public function webExecutor(Request $request, Response $response, string $controllerClassName, string $handle): void
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

        if ($this->executorDefaultConfig->getOptions("autoInject")){
            $this->proxy->getProxyInstance($instance);
        }

        /*
         * 获取控制器处理器
         */
        $method = $this->utility->getControllerHandle($response,$class,$handle);

        /*
         * prepare data
         */
        $rule = $request->getDbClient()->select("rule")->getData();


        /*
         * 执行控制器处理器
         */
        $returnData = $this->utility->handleExecutor($response,$instance,$method,$rule->getPathPara());

        /*
         * 处理返回数据
         */
        $response->doDataResponse($returnData,200);
    }
}