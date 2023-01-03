<?php

namespace muyomu\http\utility;

use JetBrains\PhpStorm\NoReturn;
use muyomu\http\client\ResponseDataClient;
use muyomu\http\message\Message;
use muyomu\http\message\MessageToArray;

class ResponseUtility implements ResponseDataClient
{

    #[NoReturn] public function returnWhite(): void
    {
        $message = new Message();
        $message->setDataType("empty");
        $message->setDataStatus("Success");
        $message->setData(null);

        $return = MessageToArray::messageToArray($message);

        $this->setHeader("Content-Type: text/json");
        echo json_encode($return, JSON_UNESCAPED_UNICODE);
        die();
    }

    #[NoReturn] public function returnRaw(mixed $data): void
    {
        $message = new Message();
        $message->setDataType(gettype($data));
        $message->setDataStatus("Success");
        $message->setData($data);

        $return = MessageToArray::messageToArray($message);

        $this->setHeader("Content-Type: text/json");
        echo json_encode($return, JSON_UNESCAPED_UNICODE);
        die();
    }

    #[NoReturn] public function returnJson(array $data): void
    {
        $message = new Message();
        $message->setDataType(gettype($data));
        $message->setDataStatus("Success");
        $message->setData($data);

        $return = MessageToArray::messageToArray($message);

        $this->setHeader("Content-Type: text/json");
        echo json_encode($return, JSON_UNESCAPED_UNICODE);
        die();
    }


    #[NoReturn] public function returnBadData(): void
    {
        $message = new Message();
        $message->setDataType("NONE");
        $message->setDataStatus("BadData");
        $message->setData(null);

        $return = MessageToArray::messageToArray($message);

        $this->setHeader("Content-Type: text/json");
        echo json_encode($return, JSON_UNESCAPED_UNICODE);
        die();
    }
}