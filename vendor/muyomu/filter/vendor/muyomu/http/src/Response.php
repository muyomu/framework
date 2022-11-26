<?php

namespace muyomu\http;

use Exception;
use JetBrains\PhpStorm\NoReturn;
use muyomu\config\ConfigParser;
use muyomu\config\exception\FieldConfigException;
use muyomu\http\client\ResponseClient;
use muyomu\http\config\DefaultHttpConfig;
use muyomu\http\exception\FileNotFoundException;
use muyomu\http\message\Message;
use muyomu\http\message\MessageToArray;

class Response implements ResponseClient
{
    private array $configData = array();

    /**
     * @throws FieldConfigException
     */
    public function __construct()
    {
        $config = new ConfigParser();
        $this->configData = $config->getConfigData(DefaultHttpConfig::class);
    }


    public function setHeader(string $field, string $content): void
    {
        $this->configData[$field] = $content;
    }

    private function addAllHeaders():void{
        $keys = array_keys($this->configData['response_header']);
        foreach ($keys as $key){
            header("${$key}:${$this->configData['response_header']}");
        }
    }

    #[NoReturn] public function doDataResponse(mixed $data,int $code): void
    {
        http_response_code($code);
        $this->addAllHeaders();

        $message = new Message();
        $message->setDataStatus("Success");
        $message->setDataType(gettype($data));
        $message->setData($data);

        $data = MessageToArray::messageToArray($message);

        die(json_encode($data));
    }

    #[NoReturn] public function doExceptionResponse(Exception $exception, int $code,): void
    {
        http_response_code($code);
        $this->addAllHeaders();

        $message = new Message();
        $message->setDataStatus("Success");
        $message->setDataType(gettype("string"));
        $message->setData($exception->getMessage());

        $data = MessageToArray::messageToArray($message);

        die(json_encode($data));
    }

    public function doFileResponse(string $file): void
    {
        $file = fopen($file,"r");
        if ($file){
            http_send_stream($file);
        }else{
            $this->doExceptionResponse(new FileNotFoundException(),400);
        }
    }
}