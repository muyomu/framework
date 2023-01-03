<?php

namespace muyomu\http;

use muyomu\database\DbClient;
use muyomu\http\client\GetClient;
use muyomu\http\client\HeaderClient;
use muyomu\http\client\PostClient;
use muyomu\http\client\RequestClient;
use muyomu\http\utility\Attribute;

class Request implements RequestClient,GetClient,PostClient,HeaderClient
{
    private DbClient $dbClient;

    private Attribute $attribute;

    public function __construct()
    {
        /*
         * 内部数据库
         */
        $this->dbClient = new DbClient();
        /*
         * 通用数据
         */
        $this->attribute = new Attribute();
    }

    /*
     * http method ==========================================
     */

    public function getRequestMethod():string{
        return $_SERVER['REQUEST_METHOD'];
    }

    public function getRemoteHost():string{
        return $_SERVER['REMOTE_HOST'];
    }

    public function getURL(): string
    {
        $data = explode("?",$_SERVER['REQUEST_URI']);
        return reset($data);
    }

    /*
     * parameter---------------------------------------------------------
     */

    public function getPara(string $varName): mixed
    {
        if (filter_has_var(INPUT_GET,$varName)){
            return $_GET[$varName];
        }else{
            return null;
        }
    }

    public function postPara(string $varName): mixed
    {
        if (filter_has_var(INPUT_GET,$varName)){
            return $_GET[$varName];
        }else{
            return null;
        }
    }

    public function getHeader(string $key):string |null{
        $headers = apache_request_headers();
        return $headers[$key] ?? null;
    }

    /*
     * model------------------------------------------------------------
     */

    public function setAttribute(string $key, mixed $value): bool
    {
        return $this->attribute->setAttribute($key,$value);
    }

    public function getAttribute(string $key): mixed
    {
        return $this->attribute->getAttribute($key);
    }


    /*
     * database==========================================================
     */

    /**
     * @return DbClient
     */
    public function getDbClient(): DbClient
    {
        return $this->dbClient;
    }

}