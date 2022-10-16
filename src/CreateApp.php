<?php

namespace muyomu\framework;

use muyomu\database\base\DataType;
use muyomu\database\base\Document;
use muyomu\database\exception\KeyNotFond;
use muyomu\database\exception\RepeatDefinition;
use muyomu\dpara\DparaClient;
use muyomu\executor\WebExecutor;
use muyomu\framework\constraint\Serve;
use muyomu\framework\plugin\Plugin;
use muyomu\framework\plugin\PluginType;
use muyomu\http\Request;
use muyomu\http\Response;
use muyomu\router\exception\RuleNotMatch;
use muyomu\router\RouterClient;
use ReflectionException;

class CreateApp implements Serve
{
    private Request $request;

    private Response $response;

    private DparaClient $dparaClient;

    private WebExecutor $webExecutor;

    public function __construct(){
        $this->request = new Request();
        $this->response = new Response();
        $this->dparaClient = new DparaClient();
        $this->webExecutor = new WebExecutor();
    }

    /**
     * @throws RuleNotMatch|RepeatDefinition|ReflectionException
     * @throws KeyNotFond
     */
    public function run():void{
        /*
         * 获取路由信息注入到request数据库中
         */
        $document = RouterClient::getRule($this->request->getURL());
        $rule =$document->getData();
        $request_db = $this->request->getDataBase();
        $document = new Document(DataType::OBJECT,Date("Y:M:D h:m:s"),Date("Y:M:D h:m:s"),0,$rule);
        $request_db->insert("rule",$document);

        /*
         * 动态参数解析
         */
        $this->dparaClient->dpara($this->request);

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

    public function __destruct()
    {
        // TODO: Implement __destruct() method.
    }
}