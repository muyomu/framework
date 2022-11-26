<?php

namespace muyomu\dpara;

use muyomu\database\DbClient;
use muyomu\dpara\client\Dpara;
use muyomu\dpara\utility\DparaHelper;
use muyomu\http\Request;
use muyomu\http\Response;

class DparaClient implements Dpara
{

    private DparaHelper $dparaHelper;

    public function __construct()
    {
        $this->dparaHelper = new DparaHelper();
    }


    /**
     * @param Request $request
     * @param Response $response
     * @param DbClient $dbClient
     * @return void
     */
    public function dpara(Request $request,Response $response, DbClient $dbClient): void
    {

        /*
         * 静态路由转换
         */
        $static_routes_table = $this->routeResolver($dbClient->database);

        /*
         * 静态路由查询
         */
        $request_uri = $request->getURL();

        //数据收集器
        $dataCollector = array();
        //键值收集器
        $keyCollector = array();
        while (1){
            $document = $this->dparaHelper->key_exits($request_uri,$static_routes_table,$request,$response,$dbClient->database,$keyCollector,$dataCollector);
            if (is_null($document)){
                $request_uri = $this->dparaHelper->get_next_url($request_uri,$dataCollector,$response);
            }else{
                break;
            }
        }

        /*
         * 将数据保存到request中的rule中
         */
        $document->getData()->setPathpara($dataCollector);
        $document->getData()->setPathkey($keyCollector);
        $request->getDbClient()->insert("rule",$document);
    }

    /*
     * 静态路由解析
     */
    private function routeResolver(array $database):array{
        $routes = array_keys($database);
        $routes_str = implode("|-|",$routes);
        $match = array();
        preg_match_all("/(\/[a-zA-Z]+)+/im",$routes_str,$match);

        //获取到所有的静态路由除开根目录
        $static_routes = $match[0];
        $static_routes = array_unique($static_routes);

        //获取到所有的静态路由对应的动态路由
        $list = array();
        foreach ($static_routes as $route){
            $ck = str_replace("/","\/",$route);
            preg_match_all("/{$ck}(\/:[a-zA-Z]*)*/im",$routes_str,$match);
            $list[$route] = $match[0];
        }
        return $list;
    }
}