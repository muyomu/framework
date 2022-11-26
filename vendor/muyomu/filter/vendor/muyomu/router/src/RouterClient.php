<?php

namespace muyomu\router;

use muyomu\database\base\Document;
use muyomu\router\model\DataBase;
use muyomu\router\model\Rule;

class RouterClient extends DataBase
{

    /**
     * @param string $method
     * @param string $uri
     * @param string $controller
     * @param string $handle
     * @return Rule
     */
    public static function rule(string $method, string $uri, string $controller, string $handle):Rule{
        $db = self::getDatabase();
        $rule=new Rule($method,$uri,$controller,$handle);
        $data = new Document($rule);
        $db->insert($uri,$data);
        return $rule;
    }

    /**
     * @param string $key
     * @return Document|null
     */
    public static function getRule(string $key):Document|null{
        $db = self::getDatabase();
        $document = $db->select($key);
        if (is_null($document)){
            return null;
        }
        return $document;
    }
}