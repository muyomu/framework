<?php

namespace muyomu\framework;

use Exception;
use muyomu\database\exception\KeyNotFond;
use muyomu\database\exception\RepeatDefinition;
use muyomu\dpara\DparaClient;
use muyomu\dpara\exception\UrlNotMatch;
use muyomu\executor\WebExecutor;
use muyomu\framework\base\BaseMiddleWare;
use muyomu\framework\constraint\Serve;
use muyomu\framework\exception\GlobalMiddleWareRepeatDefine;
use muyomu\http\Request;
use muyomu\http\Response;
use muyomu\router\RouterClient;
use ReflectionClass;
use ReflectionException;

class CreateApp implements Serve
{
    private WebExecutor $webExecutor;

    private BaseMiddleWare $middleWare;

    private DparaClient $dparaClient;

    public function __construct(){
        $this->webExecutor = new WebExecutor();
        $this->dparaClient = new DparaClient();
    }

    /**
     * @throws UrlNotMatch
     * @throws RepeatDefinition
     */
    private function do_dynamic_parameter_resolve(Request $request, Response $response):void{
        $this->dparaClient->dpara($request,RouterClient::getDatabase());
    }

    private function do_global_middleware_handle(Request $request, Response $response):void{
        if(isset($this->middleWare)){
            $this->middleWare->handle($request,$response);
        }
    }

    /**
     * @throws KeyNotFond
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
     * @throws ReflectionException
     * @throws KeyNotFond
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
     * @throws ReflectionException
     * @throws KeyNotFond
     */
    private function do_web_executor(Request $request, Response $response):void{
        $controller = $request->getDbClient()->select("rule")->getData()->getController();
        $handle = $request->getDbClient()->select("rule")->getData()->getHandle();
        $this->webExecutor->webExecutor($request,$response,$controller,$handle);
    }

    /*
     * 安装全局中间件
     */
    /**
     * @throws GlobalMiddleWareRepeatDefine
     */
    public function configApplicationMiddleWare(BaseMiddleWare $middleWare):void{
        if (isset($this->middleWare)){
            throw new GlobalMiddleWareRepeatDefine();
        }else{
            $this->middleWare = $middleWare;
        }
    }

    public function run(Request $request,Response $response):void{

        /*
         *
         */
        try {
            $this->do_dynamic_parameter_resolve($request,$response);
        }catch (UrlNotMatch|RepeatDefinition $exception){
            muix_log_warning($exception::class,$exception->getMessage());
            http_header_template();
            $response->setHeader($GLOBALS['http_code'][503]);
            die();
        }

        /*
         *
         */
        try {
            $this->do_global_middleware_handle($request,$response);
        }catch (Exception $exception){
            muix_log_warning($exception::class,$exception->getMessage());
            http_header_template();
            $response->setHeader($GLOBALS['http_code'][505]);
            die();
        }


        /*
         *
         */
        try {
            $this->do_resolve_controller($request,$response);
        }catch (Exception $exception){
            muix_log_warning($exception::class,$exception->getMessage());
            http_header_template();
            $response->setHeader($GLOBALS['http_code'][503]);
            die();
        }


        /*
         * 路由中间件处理
         */
        try {
            $this->do_route_middleware_handle($request,$response);
        }catch (Exception $exception){
            muix_log_warning($exception::class,$exception->getMessage());
            $response->setHeader($GLOBALS['http_code'][503]);
            die();
        }


        /*
         * web执行
         */
        try {
            $this->do_web_executor($request,$response);
        }catch (ReflectionException|KeyNotFond $exception){
            muix_log_warning($exception::class,$exception->getMessage());
            $response->setHeader($GLOBALS['http_code'][503]);
            die();
        }
    }
}