<?php

namespace muyomu\executor;

use muyomu\executor\client\ExecutorClient;
use muyomu\executor\config\DefaultExecutorConfig;
use muyomu\executor\exception\ServerException;
use muyomu\executor\utility\ParaResolve;
use muyomu\http\client\FormatClient;
use muyomu\http\Request;
use muyomu\http\Response;
use muyomu\inject\Proxy;
use muyomu\log4p\Log4p;
use ReflectionException;

class WebExecutor implements ExecutorClient
{
    private Utility $utility;

    private DefaultExecutorConfig $executorDefaultConfig;

    private Proxy $proxy;

    private ParaResolve $paraResolve;

    private Log4p $log4p;

    public function __construct(){

        $this->utility = new Utility();

        $this->executorDefaultConfig = new DefaultExecutorConfig();

        $this->proxy = new Proxy();

        $this->paraResolve = new ParaResolve();

        $this->log4p = new Log4p();
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

        try {
            $returnData = $this->utility->handleExecutor($response, $instance, $method, $this->paraResolve->resolvePara($method));

            if ($returnData instanceof FormatClient){
                die(json_decode($returnData->format(),JSON_UNESCAPED_UNICODE));
            }else{
                if (gettype($returnData) == "object"){
                    die(serialize($returnData));
                }else{
                    die($returnData);
                }
            }

        } catch (exception\ParaMissException|ServerException|exception\UnKnownPara $e) {
            $this->log4p->muix_log_error(__CLASS__,__METHOD__,__LINE__,$e->getMessage());
        }
    }
}