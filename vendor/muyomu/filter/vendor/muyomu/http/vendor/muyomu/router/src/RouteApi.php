<?php

namespace muyomu\router;

use muyomu\database\base\Document;
use muyomu\router\model\Rule;

class RouteApi
{

    public static function rule(string $method, string $uri, string $controller, string $handle): Rule
    {
        return RouterClient::rule($method, $uri, $controller, $handle);
    }

    public static function getRule(string $key): Document|null
    {
        return RouterClient::getRule($key);
    }
}