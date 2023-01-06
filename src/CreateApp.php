<?php

namespace muyomu\framework;

use Exception;
use muyomu\dpara\DparaClient;
use muyomu\dpara\exception\UrlNotMatch;
use muyomu\executor\exception\ServerException;
use muyomu\executor\WebExecutor;
use muyomu\framework\config\DefaultApplicationConfig;
use muyomu\framework\exception\RequestMethodNotMatchRoutException;
use muyomu\framework\generic\Serve;
use muyomu\http\Request;
use muyomu\http\Response;
use muyomu\log4p\Log4p;
use muyomu\middleware\BaseMiddleWare;
use muyomu\router\RouterClient;
use ReflectionClass;
use ReflectionException;

class CreateApp implements Serve
{
    private BaseMiddleWare $middleWare;

    private DparaClient $dparaClient;

    private WebExecutor $webExecutor;

    private Log4p $log4p;

    private DefaultApplicationConfig $defaultApplicationConfig;

    public function __construct(){
        $this->dparaClient = new DparaClient();
        $this->webExecutor = new WebExecutor();
        $this->log4p = new Log4p();
        $this->defaultApplicationConfig = new DefaultApplicationConfig();
    }

    /**
     * @param Request $request
     * @param Response $response
     * @return void
     * @throws UrlNotMatch
     */
    private function do_dynamic_parameter_resolve(Request $request, Response $response):void{
        $this->dparaClient->dpara($request,$response,RouterClient::getDatabase());
    }

    /**
     * @param Request $request
     * @param Response $response
     * @return void
     */
    private function do_global_middleware_handle(Request $request, Response $response):void{
        if(isset($this->middleWare)){
            $this->middleWare->handle($request,$response);
        }
    }

    /**
     * @param Request $request
     * @param Response $response
     * @return void
     */
    private function do_resolve_controller(Request $request, Response $response):void{
        $rule = $request->getDbClient()->select("rule")->getData();
        $rawController = $rule->getController();
        $rawController = explode(".",$rawController);
        $last = end($rawController);
        $upper = ucfirst($last);
        $rawController[sizeof($rawController)-1] = $upper;
        $endpoint = "app\\controller\\".implode("\\",$rawController);
        $rule->setController($endpoint);
    }

    /**
     * @param Request $request
     * @param Response $response
     * @return void
     * @throws ReflectionException
     */
    private function do_route_middleware_handle(Request $request, Response $response):void{
        if ($request->getDbClient()->select("rule")->getData()->getMiddleWare() !== null){
            $rule_middleware_class = new ReflectionClass($request->getDbClient()->select("rule")->getData()->getMiddleWare());
            $rule_middleware_instance = $rule_middleware_class->newInstance();
            $rule_middleware_method = $rule_middleware_class->getMethod("handle");
            $rule_middleware_method->invoke($rule_middleware_instance,$request,$response);
        }
    }

    /**
     * @throws ReflectionException|ServerException
     */
    private function do_web_executor(Request $request, Response $response):void{
        $controller = $request->getDbClient()->select("rule")->getData()->getController();
        $handle = $request->getDbClient()->select("rule")->getData()->getHandle();
        $this->webExecutor->webExecutor($request,$response,$controller,$handle);
    }

    private function checkRequestMethod(Request $request):bool{
        $routeMethod =  $request->getDbClient()->select("rule")->getData()->getMethod();
        $requestMethod = $request->getRequestMethod();
        if ($routeMethod === $requestMethod){
            return true;
        }else{
            return false;
        }
    }

    /*
     * 安装全局中间件
     */
    public function configApplicationMiddleWare(BaseMiddleWare $middleWare):void{
        $this->middleWare = $middleWare;
    }

    /**
     * @throws ServerException
     * @throws RequestMethodNotMatchRoutException
     */
    public function run(Request $request, Response $response):void{

        /*
         * 解析动态参数
         */
        try {
            $this->do_dynamic_parameter_resolve($request,$response);
        }catch (Exception $exception){
            $this->log4p->muix_log_warn(__CLASS__,__METHOD__,__LINE__,$exception->getMessage());
            throw new ServerException();
        }

        //检查请求方法是否匹配
        if (!$this->checkRequestMethod($request)){
            throw new RequestMethodNotMatchRoutException();
        }

        /*
         * 解析处理全局中间件
         */
        try {
            $this->do_global_middleware_handle($request,$response);
        }catch (Exception $exception){
            $this->log4p->muix_log_warn(__CLASS__,__METHOD__,__LINE__,$exception->getMessage());
            throw new ServerException();
        }

        /*
         * 解析控制器
         */
        try {
            if ($this->defaultApplicationConfig->getOptions("organization")){
                $this->do_resolve_controller($request,$response);
            }
        }catch (Exception $exception){
            $this->log4p->muix_log_warn(__CLASS__,__METHOD__,__LINE__,$exception->getMessage());
            throw new ServerException();
        }

        /*
         * 路由中间件处理
         */
        try {
            $this->do_route_middleware_handle($request,$response);
        }catch (Exception $exception){
            $this->log4p->muix_log_warn(__CLASS__,__METHOD__,__LINE__,$exception->getMessage());
            throw new ServerException();
        }

        /*
         * web执行
         */
        try {
            $this->do_web_executor($request,$response);
        }catch (Exception $exception){
            $this->log4p->muix_log_warn(__CLASS__,__METHOD__,__LINE__,$exception->getMessage());
            throw new ServerException();
        }
    }
}