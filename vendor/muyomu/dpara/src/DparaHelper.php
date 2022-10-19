<?php

namespace muyomu\dpara;

use muyomu\database\base\DataType;
use muyomu\database\base\Document;
use muyomu\database\DbClient;
use muyomu\database\exception\RepeatDefinition;
use muyomu\dpara\client\UrlValidate;
use muyomu\dpara\exception\UrlNotMatch;
use muyomu\http\Request;

class DparaHelper implements UrlValidate
{

    /**
     * @throws UrlNotMatch|RepeatDefinition
     */
    public function key_exits(string $key, array $database,Request $request,array $dataCollector, array $keyCollector,array $dbClient): bool
    {
        here:
        if (array_key_exists($key,$database)){
            //获取到所有的动态路由
            $dynamic_routes = $database[$key];
            $paraLength = count($dataCollector);
            //通过数据长度匹配动态路由
            $point = null;
            foreach ($dynamic_routes as $route){
                $match = array();
                preg_match_all("/\/:([a-zA-Z]+)/m",$route,$match);
                array_shift($match);
                if (empty($match[0])){
                    $length = 0;
                }else{
                    $length = count($match);
                }
                if ($length == $paraLength){
                    foreach ($match as $value){
                        array_push($keyCollector,$value);
                    }
                    $point = $route;
                    break;
                }
            }
            /*
             * 判断point
             */
            if (is_null($point)){
                throw new UrlNotMatch();
            }

            //保存route到request
            $request_db = $request->getDataBase();
            $document = new Document(DataType::OBJECT,Date("Y:M:D h:m:s"),Date("Y:M:D h:m:s"),0,$dbClient[$key]->getData());
            $request_db->insert("rule",$document);
            return true;
        }else{
            $key = $this->get_next_url($key,$dataCollector);
            goto here;
        }
    }

    /**
     * @throws UrlNotMatch
     */
    public function get_next_url(string $url, array $dataCollector): string
    {
        if (strcmp("/",$url)){
            throw new UrlNotMatch();
        }else{
            $items = explode("/",$url);
            array_shift($items);
            $value = array_pop($items);
            array_push($dataCollector,$value);
            return $this->get_combined_url($items);
        }
    }

    public function get_combined_url(array $items): string
    {
        return "/".implode("/",$items);
    }
}