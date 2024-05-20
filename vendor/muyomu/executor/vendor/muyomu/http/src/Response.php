<?php

namespace muyomu\http;

use Exception;
use muyomu\http\client\FormatClient;
use muyomu\http\client\HttpClient;
use muyomu\http\client\ResponseClient;
use muyomu\http\config\DefaultHttpConfig;
use muyomu\http\exception\FileNotFoundException;
use muyomu\http\format\ExceptionFormat;
use muyomu\http\utility\HeaderUtility;

class Response implements ResponseClient, HttpClient
{

    private DefaultHttpConfig $defaultHttpConfig;

    private HeaderUtility $headerUtility;

    public function __construct()
    {
        $this->defaultHttpConfig = new DefaultHttpConfig();

        $this->headerUtility = new HeaderUtility();
    }

    //response

    /**
     * @param string $fileName
     * @param bool $display
     * @return void
     * @throws FileNotFoundException
     */
    public function doPlainResponse(string $fileName, bool $display = true): void
    {
        //设置响应码
        http_response_code(200);

        //设置通用响应头
        $this->headerUtility->addAllHeaders($this->defaultHttpConfig->getOptions("headers"));

        //设置专用响应头
        if ($display){

            $position  = "inline";
            $this->setHeader("Content-Disposition",$position);

        }else{
            $position  = "attachment";
            $this->setHeader("Content-Disposition",$position.";filename=".pathinfo($fileName,PATHINFO_BASENAME));
        }

        $this->setHeader("Content-Type","text/plain;charset=utf-8");

        //获取文件位置
        $file_location = $GLOBALS["super_config"]["resDir"].$fileName;

        //打开文件
        $resource = fopen($file_location,"r");

        if ($resource){

            //获取文件内容
            $content = fread($resource,filesize($file_location));

            //输出文件内容
            die($content);
        }else{

            throw new FileNotFoundException();
        }
    }

    /**
     * @param string $fileName
     * @param bool $display
     * @return void
     * @throws FileNotFoundException
     */
    public function doJsonResponse(string $fileName, bool $display = true): void
    {
        //设置响应码
        http_response_code(200);

        //设置通用响应头
        $this->headerUtility->addAllHeaders($this->defaultHttpConfig->getOptions("headers"));

        //设置专用响应头
        if ($display){

            $position  = "inline";
            $this->setHeader("Content-Disposition",$position);

        }else{
            $position  = "attachment";
            $this->setHeader("Content-Disposition",$position.";filename=".pathinfo($fileName,PATHINFO_BASENAME));
        }

        $this->setHeader("Content-Type","text/json;charset=utf-8");

        //获取文件位置
        $file_location = $GLOBALS["super_config"]["resDir"].$fileName;

        //打开文件
        $resource = fopen($file_location,"r");

        if ($resource){

            //获取文件内容
            $content = fread($resource,filesize($file_location));

            //输出文件内容
            die($content);
        }else{

            throw new FileNotFoundException();
        }
    }

    /**
     * @param string $fileName
     * @param bool $display
     * @return void
     * @throws FileNotFoundException
     */
    public function doXmlResponse(string $fileName, bool $display = true): void
    {
        //设置响应码
        http_response_code(200);

        //设置通用响应头
        $this->headerUtility->addAllHeaders($this->defaultHttpConfig->getOptions("headers"));

        //设置专用响应头
        if ($display){

            $position  = "inline";
            $this->setHeader("Content-Disposition",$position);

        }else{
            $position  = "attachment";
            $this->setHeader("Content-Disposition",$position.";filename=".pathinfo($fileName,PATHINFO_BASENAME));
        }

        $this->setHeader("Content-Type","text/xml;charset=utf-8");

        //获取文件位置
        $file_location = $GLOBALS["super_config"]["resDir"].$fileName;

        //打开文件
        $resource = fopen($file_location,"r");

        if ($resource){

            //获取文件内容
            $content = fread($resource,filesize($file_location));

            //输出文件内容
            die($content);
        }else{

            throw new FileNotFoundException();
        }
    }

    /**
     * @param string $fileName
     * @param bool $display
     * @return void
     * @throws FileNotFoundException
     */
    public function doImageResponse(string $fileName, bool $display = true): void
    {
        //设置响应码
        http_response_code(200);

        //设置通用响应头
        $this->headerUtility->addAllHeaders($this->defaultHttpConfig->getOptions("headers"));

        //设置专用响应头
        if ($display){

            $position  = "inline";
            $this->setHeader("Content-Disposition",$position);

        }else{
            $position  = "attachment";
            $this->setHeader("Content-Disposition",$position.";filename=".pathinfo($fileName,PATHINFO_BASENAME));
        }

        $this->setHeader("Content-Type","image/".pathinfo($fileName,PATHINFO_EXTENSION).";charset=utf-8");

        //获取文件位置
        $file_location = $GLOBALS["super_config"]["resDir"].$fileName;

        //打开文件
        $resource = fopen($file_location,"r");

        if ($resource){

            //获取文件内容
            $content = fread($resource,filesize($file_location));

            //输出文件内容
            die($content);
        }else{

            throw new FileNotFoundException();
        }
    }

    /**
     * @param string $fileName
     * @param bool $display
     * @return void
     * @throws FileNotFoundException
     */
    public function doVideoResponse(string $fileName, bool $display = true): void
    {
        //设置响应码
        http_response_code(200);

        //设置通用响应头
        $this->headerUtility->addAllHeaders($this->defaultHttpConfig->getOptions("headers"));

        //设置专用响应头
        if ($display){

            $position  = "inline";
            $this->setHeader("Content-Disposition",$position);

        }else{
            $position  = "attachment";
            $this->setHeader("Content-Disposition",$position.";filename=".pathinfo($fileName,PATHINFO_BASENAME));
        }

        $this->setHeader("Content-Type","video/".pathinfo($fileName,PATHINFO_EXTENSION).";charset=utf-8");

        //获取文件位置
        $file_location = $GLOBALS["super_config"]["resDir"].$fileName;

        //打开文件
        $resource = fopen($file_location,"r");

        if ($resource){

            //获取文件内容
            $content = fread($resource,filesize($file_location));

            //输出文件内容
            die($content);
        }else{

            throw new FileNotFoundException();
        }
    }

    /**
     * @param string $fileName
     * @param bool $display
     * @return void
     * @throws FileNotFoundException
     */
    public function doAudioResponse(string $fileName, bool $display = true): void
    {
        //设置响应码
        http_response_code(200);

        //设置通用响应头
        $this->headerUtility->addAllHeaders($this->defaultHttpConfig->getOptions("headers"));

        //设置专用响应头
        if ($display){

            $position  = "inline";
            $this->setHeader("Content-Disposition",$position);

        }else{
            $position  = "attachment";
            $this->setHeader("Content-Disposition",$position.";filename=".pathinfo($fileName,PATHINFO_BASENAME));
        }

        $this->setHeader("Content-Type","audio/".pathinfo($fileName,PATHINFO_EXTENSION).";charset=utf-8");

        //获取文件位置
        $file_location = $GLOBALS["super_config"]["resDir"].$fileName;

        //打开文件
        $resource = fopen($file_location,"r");

        if ($resource){

            //获取文件内容
            $content = fread($resource,filesize($file_location));

            //输出文件内容
            die($content);
        }else{

            throw new FileNotFoundException();
        }
    }

    /**
     * @param string $fileName
     * @return void
     * @throws FileNotFoundException
     */
    public function doResourceResponse(string $fileName):void{
        //设置响应码
        http_response_code(200);

        //设置通用响应头
        $this->headerUtility->addAllHeaders($this->defaultHttpConfig->getOptions("headers"));

        $this->setHeader("Content-Disposition","attachment;filename=".pathinfo($fileName,PATHINFO_BASENAME));

        $this->setHeader("Content-Type","image/".pathinfo($fileName,PATHINFO_EXTENSION).";charset=utf-8");

        //获取文件位置
        $file_location = $GLOBALS["super_config"]["resDir"].$fileName;

        //打开文件
        $resource = fopen($file_location,"r");

        if ($resource){

            //获取文件内容
            $content = fread($resource,filesize($file_location));

            //输出文件内容
            die($content);
        }else{

            throw new FileNotFoundException();
        }
    }

    //http
    /**
     * @param string $url
     * @return void
     */
    public function reDirect(string $url):void{
        $this->setHeader("Location",$url);
        die();
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
     * @param Exception $exception
     * @param int $code
     * @return void
     */
    public function doExceptionResponse(Exception $exception, int $code, int $httpCode = 200): void
    {
        //设置状态码
        http_response_code($httpCode);

        //设置通用响应头
        $this->headerUtility->addAllHeaders($this->defaultHttpConfig->getOptions("headers"));

        //设置专用响应头
        $this->setHeader("Content-Type","text/json:charset=utf-8");

        //数据格式
        $format = new ExceptionFormat($code,"Exception","String",$exception->getMessage());

        //返回数据
        die(json_encode($format->format(),JSON_UNESCAPED_UNICODE));
    }

    //view

    /**
     * @param string $fileName
     * @return void
     * @throws FileNotFoundException
     */
    public function doViewResponse(string $fileName):void{
        //设置响应码
        http_response_code(200);

        //设置通用响应头
        $this->headerUtility->addAllHeaders($this->defaultHttpConfig->getOptions("headers"));

        $this->setHeader("Content-Disposition","inline;filename=".pathinfo($fileName,PATHINFO_BASENAME));

        $this->setHeader("Content-Type","text/".pathinfo($fileName,PATHINFO_EXTENSION).";charset=utf-8");

        //获取文件位置
        $file_location = $GLOBALS["super_config"]["resDir"].$fileName;

        //打开文件
        $resource = fopen($file_location,"r");

        if ($resource){

            //获取文件内容
            $content = fread($resource,filesize($file_location));

            //输出文件内容
            die($content);
        }else{

            throw new FileNotFoundException();
        }
    }

    public function doFormatResponse(FormatClient $format, int $code, int $httpCode = 200): void
    {
        //设置状态码
        http_response_code($httpCode);

        //设置通用响应头
        $this->headerUtility->addAllHeaders($this->defaultHttpConfig->getOptions("headers"));

        //设置专用响应头
        $this->setHeader("Content-Type","text/json:charset=utf-8");

        //返回数据
        die(json_encode($format->format(),JSON_UNESCAPED_UNICODE));
    }
}