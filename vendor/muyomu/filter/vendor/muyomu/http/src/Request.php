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
        $this->dbClient = new DbClient();

        $this->attribute = new Attribute();
    }

    /*
     * http method ==========================================
     */

    /**
     * @return string
     */
    public function getRequestMethod():string{
        return $_SERVER['REQUEST_METHOD'];
    }

    /**
     * @return string
     */
    public function getRemoteHost():string{
        return $_SERVER['REMOTE_HOST'];
    }

    /**
     * @return string
     */
    public function getURL(): string
    {
        $data = explode("?",$_SERVER['REQUEST_URI']);
        return reset($data);
    }

    /*
     * parameter---------------------------------------------------------
     */

    /**
     * @param string $varName
     * @return mixed
     */
    public function getPara(string $varName): mixed
    {
        if (filter_has_var(INPUT_GET,$varName)){
            return $_GET[$varName];
        }else{
            return null;
        }
    }

    /**
     * @param string $varName
     * @return mixed
     */
    public function postPara(string $varName): mixed
    {
        if (filter_has_var(INPUT_GET,$varName)){
            return $_GET[$varName];
        }else{
            return null;
        }
    }

    /**
     * @param string $key
     * @return string|null
     */
    public function getHeader(string $key):string |null{
        $headers = apache_request_headers();
        return $headers[$key] ?? null;
    }

    /*
     * model------------------------------------------------------------
     */

    /**
     * @param string $key
     * @param mixed $value
     * @return bool
     */
    public function setAttribute(string $key, mixed $value): bool
    {
        return $this->attribute->setAttribute($key,$value);
    }

    /**
     * @param string $key
     * @return mixed
     */
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