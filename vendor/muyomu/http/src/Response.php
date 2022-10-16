<?php

namespace muyomu\http;

use muyomu\http\client\ResponseClient;
use muyomu\http\message\Message;

class Response implements ResponseClient
{
    /*
     * 内部数据库
     */
    private Request $request;

    /**
     * @param Request $request
     */
    public function setRequest(Request $request): void
    {
        $this->request = $request;
    }

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

        $return = array();
        $return['code'] = $message->getDataCode();
        $return['status'] = $message->getDataStatus();
        $return['dateType'] = $message->getDataType();

        echo json_encode($return, JSON_UNESCAPED_UNICODE);
    }

    public function returnRaw(mixed $data): void
    {
        $message = new Message();
        $message->setDataCode(200);
        $message->setDataType(gettype($data));
        $message->setDataStatus("Success");
        $message->setData($data);

        $return = array();
        $return['code'] = $message->getDataCode();
        $return['status'] = $message->getDataStatus();
        $return['dateType'] = $message->getDataType();
        $return['data'] = $message->getData();

        echo json_encode($return, JSON_UNESCAPED_UNICODE);
    }

    public function returnJson(array $data): void
    {
        $message = new Message();
        $message->setDataCode(200);
        $message->setDataType(gettype($data));
        $message->setDataStatus("Success");
        $message->setData($data);

        $return = array();
        $return['code'] = $message->getDataCode();
        $return['status'] = $message->getDataStatus();
        $return['dateType'] = $message->getDataType();
        $return['data'] = $message->getData();

        echo json_encode($return, JSON_UNESCAPED_UNICODE);
    }
}