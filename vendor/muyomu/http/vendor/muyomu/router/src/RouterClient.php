<?php

namespace muyomu\router;

use muyomu\database\base\DataType;
use muyomu\database\base\Document;
use muyomu\database\exception\KeyNotFond;
use muyomu\database\exception\RepeatDefinition;
use muyomu\router\exception\RuleNotMatch;
use muyomu\router\model\DataBase;
use muyomu\router\model\Rule;

class RouterClient extends DataBase
{
    /**
     * @throws RepeatDefinition
     */
    public static function rule(string $method, string $uri, string $controller, string $handle):Rule{
        $db = self::getDatabase();
        $rule=new Rule($uri,$method,$controller,$handle);
        $data = new Document(DataType::OBJECT,date("Y:M:D h:m:s"),date("Y:M:D h:m:s"),0,$rule);
        $db->insert($uri,$data);
        return $rule;
    }

    /**
     * @throws RuleNotMatch
     */
    public static function getRule(string $key):Document{
        $db = self::getDatabase();
        $document =null;
        try {
            $document = $db->select($key);
        }catch (KeyNotFond $exception){
            throw new RuleNotMatch();
        }
        return $document;
    }
}