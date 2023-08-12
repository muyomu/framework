<?php

namespace muyomu\http;

use Exception;
use muyomu\http\client\ResponseClient;
use muyomu\http\config\DefaultFileConfig;
use muyomu\http\config\DefaultHttpConfig;
use muyomu\http\exception\FileNotFoundException;
use muyomu\http\message\Message;
use muyomu\http\message\MessageToArray;

class Response implements ResponseClient
{
    private DefaultFileConfig $defaultFileConfig;

    private DefaultHttpConfig $defaultHttpConfig;

    public function __construct()
    {
        $this->defaultFileConfig = new DefaultFileConfig();
        $this->defaultHttpConfig = new DefaultHttpConfig();
    }

    /**
     * @param string $field
     * @param string $content
     * @return void
     */
    public function setHeader(string $field, string $content): void
    {
        $header = "$field: $content";
        header($header);
    }

    /**
     * @param array $config
     * @return void
     */
    private function addAllHeaders(array $config):void{
        $keys = array_keys($config);
        foreach ($keys as $key){
            $value = $config[$key];
            $header = "$key: $value";
            header("$header");
        }
    }

    /**
     * @param int $code
     * @param string $status
     * @param mixed $data
     * @return void
     */
    public function doJsonResponse(int $code,string $status,mixed $data): void
    {
        //设置响应码
        http_response_code($code);
        //设置响应头
        $this->addAllHeaders($this->defaultHttpConfig->getOptions("headers"));

        //设置专用响应头
        $this->setHeader("Content-Type","txt/json:charset=utf-8");

        //封装回应体
        $message = new Message();
        $message->setDataStatus($status);
        $message->setDataType(gettype($data));
        $message->setData($data);

        //封装json
        $data = MessageToArray::messageToArray($message);

        //返回Json数据
        die(json_encode($data,JSON_UNESCAPED_UNICODE));
    }

    /**
     * @param Exception $exception
     * @param int $code
     * @return void
     */
    public function doExceptionResponse(Exception $exception, int $code,): void
    {
        //设置状态码
        http_response_code($code);
        //设置通用响应头
        $this->addAllHeaders($this->defaultHttpConfig->getOptions("headers"));

        //设置专用响应头
        $this->setHeader("Content-Type","txt/json:charset=utf-8");

        $message = new Message();
        $message->setDataStatus("Failure");
        $message->setDataType(gettype("string"));
        $message->setData($exception->getMessage());

        $data = MessageToArray::messageToArray($message);

        //返回数据
        die(json_encode($data,JSON_UNESCAPED_UNICODE));
    }

    /**
     * @param string $file
     * @return void
     */
    public function doFileResponse(string $file): void
    {
        //获取文件位置
        $file_location = $this->defaultFileConfig->getOptions("location").$file;

        //打开文件
        $resource = fopen($file_location,"r");
        if ($resource){
            //设置通用响应头
            $this->addAllHeaders($this->defaultFileConfig->getOptions("headers"));

            //设置专用响应头
            Header ( "Accept-Length: " . filesize ($file_location) );
            Header ( "Content-Disposition: attachment; filename=" . $file );

            //获取文件内容
            $content = fread($resource,filesize($file_location));

            //输出文件内容
            die($content);
        }else{
            $this->doExceptionResponse(new FileNotFoundException(),404);
        }
    }

    /**
     * @param string $file
     * @return void
     */
    public function doStreamResponse(string $file): void
    {
        //获取资源位置
        $file_location = $this->defaultFileConfig->getOptions("location").$file;

        //打开资源文件
        $resource = fopen($file_location,"r");

        if ($resource){
            //设置通用响应头
            $this->addAllHeaders($this->defaultFileConfig->getOptions("headers"));

            //设置专用响应头
            Header ( "Accept-Length: " . filesize ($file_location) );

            //获取文件内容
            $content = fread($resource,filesize($file_location));

            //返回流文件
            die($content);
        }else{
            $this->doExceptionResponse(new FileNotFoundException(),404);
        }
    }
}