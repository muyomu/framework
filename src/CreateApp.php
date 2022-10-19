<?php

namespace muyomu\framework;

use muyomu\database\base\DataType;
use muyomu\database\base\Document;
use muyomu\database\exception\KeyNotFond;
use muyomu\database\exception\RepeatDefinition;
use muyomu\dpara\DparaClient;
use muyomu\dpara\exception\UrlNotMatch;
use muyomu\executor\WebExecutor;
use muyomu\framework\base\BaseMiddleWare;
use muyomu\framework\constraint\Serve;
use muyomu\framework\exception\GlobalMiddleWareRepeatDefine;
use muyomu\framework\plugin\Plugin;
use muyomu\framework\plugin\PluginType;
use muyomu\http\Request;
use muyomu\http\Response;
use muyomu\router\exception\RuleNotMatch;
use muyomu\router\RouterClient;
use ReflectionClass;
use ReflectionException;

class CreateApp implements Serve
{
    private Request $request;

    private Response $response;

    private WebExecutor $webExecutor;

    private BaseMiddleWare $middleWare;

    private DparaClient $dparaClient;

    public function __construct(){
        $this->request = new Request();
        $this->response = new Response();
        $this->webExecutor = new WebExecutor();
        $this->dparaClient = new DparaClient();
    }

    /**
     * @throws RuleNotMatch|RepeatDefinition|ReflectionException
     * @throws KeyNotFond
     * @throws UrlNotMatch
     */
    public function run():void{
        /*
         * dpara路由处理器
         */
        $this->dparaClient->dpara($this->request,RouterClient::getDatabase());

        /*
         * 根路由处理
         */

        /*
         * 全局拦截器处理
         */
        if(isset($this->middleWare)){
            $this->middleWare->handle($this,$this->request,function (CreateApp $application, string $action,...$values){
                switch ($action){
                    case "redirect":echo "redirect";break;
                    case "forward": echo "forward";break;
                }
            });
        }


        /*
         * 解析控制器
         */
        $rule = $this->request->getDataBase()->select("rule")->getData();
        $rawController = $rule->getController();
        $rawController = explode(".",$rawController);
        $last = end($rawController);
        $upper = ucfirst($last);
        $rawController[sizeof($rawController)-1] = $upper;
        $endpoint = "app\\controller\\".implode("\\",$rawController);
        $rule->setController($endpoint);
        $this->request->getDataBase()->select("rule")->setModifyTime(date("Y:M:D h:m:s"));
        $this->request->getDataBase()->select("rule")->setVersion($this->request->getDataBase()->select("rule")->getVersion()+1);


        /*
         * 路由中间件处理
         */
        if ($this->request->getDataBase()->select("rule")->getData()->getMiddleWare() !== null){
            $rule_middleware_class = new ReflectionClass($this->request->getDataBase()->select("rule")->getData()->getMiddleWare());
            $rule_middleware_instance = $rule_middleware_class->newInstance();
            $rule_middleware_method = $rule_middleware_class->getMethod("handle");
            $rule_middleware_method->invoke($rule_middleware_instance,$this,$this->request,function (CreateApp $application, string $action,...$values){
                switch ($action){
                    case "redirect":echo "redirect";break;
                    case "forward": echo "forward";break;
                }
            });
        }

        /*
         * web执行
         */
        $controller = $this->request->getDataBase()->select("rule")->getData()->getController();
        $method = $this->request->getDataBase()->select("rule")->getData()->getHandle();
        $this->webExecutor->webExecutor($this->request,$this->response,$controller,$method);
    }

    /*
     * 安装插件
     */
    public function installPlugin(PluginType $pluginType,Plugin $plugin){

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

    public function __destruct()
    {
        // TODO: Implement __destruct() method.
    }
}