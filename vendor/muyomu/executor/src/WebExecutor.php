<?php

namespace muyomu\executor;

use muyomu\executor\client\ExecutorClient;
use muyomu\executor\config\DefaultExecutorConfig;
use muyomu\executor\exception\ServerException;
use muyomu\executor\utility\ParaResolve;
use muyomu\executor\utility\Utility;
use muyomu\http\client\FormatClient;
use muyomu\http\Request;
use muyomu\http\Response;
use muyomu\inject\ProxyExecutor;
use muyomu\log4p\Log4p;
use ReflectionException;

class WebExecutor implements ExecutorClient
{
    private Utility $utility;

    private DefaultExecutorConfig $executorDefaultConfig;

    private ProxyExecutor $proxy;

    private ParaResolve $paraResolve;

    private Log4p $log4p;

    public function __construct(){

        $this->utility = new Utility();

        $this->executorDefaultConfig = new DefaultExecutorConfig();

        $this->proxy = new ProxyExecutor();

        $this->paraResolve = new ParaResolve();

        $this->log4p = new Log4p();
    }

    /**
     * @param Request $request
     * @param Response $response
     * @param string $controllerClassName
     * @param string $handle
     * @return void
     * @throws ReflectionException
     * @throws ServerException
     */
    public function webExecutor(Request $request, Response $response, string $controllerClassName, string $handle): void
    {
        //获取控制器反射类
        $class = $this->utility->getReflectionClass($response,$controllerClassName);

        //获取控制器实例
        $instance = $this->utility->getControllerInstance($response,$class);

        //注入request,response
        $this->utility->injectRR($request,$response,$class,$instance);

        //自动注入依赖
        if ($this->executorDefaultConfig->getOptions("autoInject")){
            $this->proxy->getProxyInstance($instance);
        }

        //获取控制器处理器
        $method = $this->utility->getControllerHandle($class,$handle);

        //执行控制器处理器
        try {
            $returnData = $this->utility->handleExecutor($instance, $method, $this->paraResolve->resolvePara($method));

            if ($returnData instanceof FormatClient){

                header("Content-Type:text/json;charset=utf-8");

                die(json_encode($returnData->format(),JSON_UNESCAPED_UNICODE));

            }else{

                if (gettype($returnData) == "object"){

                    die(serialize($returnData));
                }elseif (gettype($returnData) == "array"){

                    die(json_encode($returnData,JSON_UNESCAPED_UNICODE));
                }
                else{
                    die($returnData);
                }
            }

        } catch (exception\ParaMissException|ServerException|exception\UnKnownPara $e) {

            $this->log4p->muix_log_error(__CLASS__,__METHOD__,__LINE__,$e->getMessage());

            throw new ServerException();
        }
    }
}