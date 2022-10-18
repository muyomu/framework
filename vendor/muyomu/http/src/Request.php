<?php

namespace muyomu\http;

use muyomu\database\DbClient;
use muyomu\http\client\GetClient;
use muyomu\http\client\PostClient;
use muyomu\http\client\RequestClient;
use muyomu\http\exception\HeaderNotFound;
use muyomu\http\exception\ParaNotExit;
use muyomu\router\model\Rule;

class Request implements RequestClient,GetClient,PostClient
{
    private DbClient $dbClient;

    private Rule $rule;
    /*
     * 固定信息
     */
    public function __construct()
    {
        $this->dbClient = new DbClient();
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

    /**
     * @return Rule
     */
    public function getRule(): Rule
    {
        return $this->rule;
    }

    /**
     * @param Rule $rule
     */
    public function setRule(Rule $rule): void
    {
        $this->rule = $rule;
    }
}