<?php

namespace muyomu\dpara;

use muyomu\database\base\DataType;
use muyomu\database\base\Document;
use muyomu\database\exception\RepeatDefinition;
use muyomu\dpara\client\UrlValidate;
use muyomu\dpara\exception\UrlNotMatch;
use muyomu\http\Request;

class DparaHelper implements UrlValidate
{

    /**
     * @throws UrlNotMatch|RepeatDefinition
     */
    public function key_exits(string $key, array $database,Request $request): bool
    {
        here:
        if (array_key_exists($key,$database)){
            $request_db = $request->getDataBase();
            $document = new Document(DataType::OBJECT,Date("Y:M:D h:m:s"),Date("Y:M:D h:m:s"),0,$database[$key]);
            $request_db->insert("rule",$document);
            return true;
        }else{
            $key = $this->get_next_url($key,$database);
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