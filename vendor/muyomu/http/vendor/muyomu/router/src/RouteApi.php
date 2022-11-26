<?php

namespace muyomu\router;

use Exception;
use muyomu\database\base\Document;
use muyomu\log4p\Log4p;
use muyomu\router\model\Rule;

class RouteApi
{

    public static function rule(string $method, string $uri, string $controller, string $handle): Rule
    {
        $logger = new Log4p();

        $rule = null;
        try {
            $rule = RouterClient::rule($method, $uri, $controller, $handle);
        }catch (Exception $exception){
            $logger->muix_log_warn(__CLASS__,__METHOD__,$exception->getMessage());
            http_response_code(500);
            die();
        }
        return $rule;
    }

    public static function getRule(string $key): Document
    {
        $logger = new Log4p();

        try {
            $document = RouterClient::getRule($key);
        }catch (Exception $exception){
            $logger->muix_log_warn(__CLASS__,__METHOD__,$exception->getMessage());
            http_response_code(500);
            die();
        }
        return  $document;
    }
}