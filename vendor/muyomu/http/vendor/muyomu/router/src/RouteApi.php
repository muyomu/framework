<?php

namespace muyomu\router;

use Exception;
use muyomu\database\base\Document;
use muyomu\router\model\Rule;

class RouteApi extends RouterClient
{
    public static function rule(string $method, string $uri, string $controller, string $handle): Rule
    {
        $rule = null;
        try {
            $rule = parent::rule($method, $uri, $controller, $handle);
        }catch (Exception $exception){
            echo $exception->getMessage();
        }
        return $rule;
    }

    public static function getRule(string $key): Document
    {
        $document = null;
        try {
            $document = parent::getRule($key);
        }catch (Exception $exception){
            echo $exception->getMessage();
        }
        return  $document;
    }
}