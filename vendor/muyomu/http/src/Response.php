<?php

namespace muyomu\http;

use muyomu\http\client\ResponseClient;
use muyomu\http\message\Message;
use muyomu\http\message\MessageToArray;

class Response implements ResponseClient
{
    public function setHeader(string $header):void
    {
        header($header);
    }

    public function doResponse(mixed $data): void
    {
        switch (gettype($data)){
            case "integer":
            case "boolean":
            case "double":
            case "string": $this->returnRaw($data);break;
            case "NULL": $this->returnWhite();break;
            case "array": $this->returnJson($data);break;
        }

    }

    public function returnWhite(): void
    {
        $message = new Message();
        $message->setDataCode(200);
        $message->setDataType("empty");
        $message->setDataStatus("Success");
        $message->setData(null);

        $return = MessageToArray::messageToArray($message);

        echo json_encode($return, JSON_UNESCAPED_UNICODE);
    }

    public function returnRaw(mixed $data): void
    {
        $message = new Message();
        $message->setDataCode(200);
        $message->setDataType(gettype($data));
        $message->setDataStatus("Success");
        $message->setData($data);

        $return = MessageToArray::messageToArray($message);

        echo json_encode($return, JSON_UNESCAPED_UNICODE);
    }

    public function returnJson(array $data): void
    {
        $message = new Message();
        $message->setDataCode(200);
        $message->setDataType(gettype($data));
        $message->setDataStatus("Success");
        $message->setData($data);

        $return = MessageToArray::messageToArray($message);

        echo json_encode($return, JSON_UNESCAPED_UNICODE);
    }
}