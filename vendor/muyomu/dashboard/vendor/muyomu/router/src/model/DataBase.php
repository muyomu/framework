<?php

namespace muyomu\router\model;

use muyomu\database\DbClient;

abstract class DataBase
{
    private static DbClient $database;

    public static function init():void{
        if (empty(DataBase::$database)){
            DataBase::$database = new DbClient();
        }
    }

    public static function getDatabase():DbClient{
        self::init();
        return self::$database;
    }
}