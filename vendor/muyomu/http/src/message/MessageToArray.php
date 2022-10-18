<?php

namespace muyomu\http\message;

class MessageToArray
{
    public static function messageToArray(Message $message):array{
        $return = array();
        $return['code'] = $message->getDataCode();
        $return['status'] = $message->getDataStatus();
        $return['dateType'] = $message->getDataType();
        $return['data'] = $message->getData();
        return $return;
    }
}