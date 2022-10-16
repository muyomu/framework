<?php

namespace muyomu\http;

use muyomu\database\DbClient;
use muyomu\http\client\RequestClient;
use muyomu\http\exception\HeaderNotFound;

class Request implements RequestClient
{
    private DbClient $dbClient;

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
}