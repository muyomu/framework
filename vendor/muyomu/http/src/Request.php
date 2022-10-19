<?php

namespace muyomu\http;

use muyomu\database\DbClient;
use muyomu\http\client\GetClient;
use muyomu\http\client\PostClient;
use muyomu\http\client\RequestClient;
use muyomu\http\exception\HeaderNotFound;
use muyomu\http\exception\ParaNotExit;

class Request implements RequestClient,GetClient,PostClient
{
    private DbClient $dbClient;

    private array $database = array();

    private Attribute $attribute;
    /*
     * 固定信息
     */
    public function __construct()
    {
        $this->dbClient = new DbClient();
        $this->attribute = new Attribute();
    }

    public function getRequestMethod():string{
        return $_SERVER['REQUEST_METHOD'];
    }

    public function getRequestURI():string{
        return $_SERVER['REQUEST_URI'];
    }

    public function getRemoteHost():string{
        return $_SERVER['REMOTE_HOST'];
    }

    public function getRemotePort():int{
        return $_SERVER['REMOTE_PORT'];
    }

    public function getDataBase():DbClient{
        return $this->dbClient;
    }

    /*
     * 动态信息
     */
    /**
     * @throws HeaderNotFound
     */
    public function getHeader(string $key):string{
        if(array_key_exists($key,$_SERVER)){
            throw new HeaderNotFound();
        }else{
            return $_SERVER[$key];
        }
    }

    public function getQueryString(): string
    {
        return $_SERVER['QUERY_STRING'];
    }

    public function getProtocol(): string
    {
        return $_SERVER['SERVER_PROTOCOL'];
    }

    public function getURL(): string
    {
        $data = explode("?",$_SERVER['REQUEST_URI']);
        return reset($data);
    }

    /**
     * @throws ParaNotExit
     */
    public function getPara(string $varName): mixed
    {
        if (filter_has_var("INPUT_GET",$varName)){
            return $_GET[$varName];
        }else{
            throw new ParaNotExit();
        }
    }

    /**
     * @throws ParaNotExit
     */
    public function postPara(string $varName): mixed
    {
        if (filter_has_var("INPUT_GET",$varName)){
            return $_GET[$varName];
        }else{
            throw new ParaNotExit();
        }
    }

    public function setAttribute(string $key, mixed $value): bool
    {
        return $this->attribute->setAttribute($key,$value,$this->database);
    }

    public function getAttribute(string $key): mixed
    {
        return $this->attribute->getAttribute($key,$this->database);
    }
}