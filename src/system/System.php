<?php

namespace muyomu\framework\system;

use muyomu\http\message\Message;

class System
{
    public static function system():void{
        //global exception handle
        set_exception_handler(function ($exception) {
            $message = new Message();
            $message->setDataStatus("ServerError");
            $message->setDataType("Describe Message");
            $message->setData($exception->getMessage());

            header("Content-Type: text/json;charset=UTF-8");

            $return = array();
            $return['status'] = $message->getDataStatus();
            $return['dateType'] = $message->getDataType();
            $return['data'] = $message->getData();

            echo json_encode($return, JSON_UNESCAPED_UNICODE);
        });

        //global error handle
        set_error_handler(function ($error, $message) {
            $message = new Message();
            $message->setDataStatus("ServerError");
            $message->setDataType("Describe Message");
            $message->setData($message);

            header("Content-Type: text/json;charset=UTF-8");

            $return = array();
            $return['status'] = $message->getDataStatus();
            $return['dateType'] = $message->getDataType();
            $return['data'] = $message->getData();

            echo json_encode($return, JSON_UNESCAPED_UNICODE);
        });
    }
}