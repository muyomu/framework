<?php

namespace muyomu\executor;

use muyomu\aop\FrameWorkClient;
use muyomu\executor\client\ExecutorHelper;
use muyomu\executor\exception\ServerException;
use muyomu\http\Request;
use muyomu\http\Response;
use muyomu\log4p\Log4p;
use ReflectionClass;
use ReflectionException;
use ReflectionMethod;

class Utility implements ExecutorHelper
{
    private FrameWorkClient $frameWorkClient;

    private Log4p $log4p;

    public function __construct()
    {
        $this->frameWorkClient = new FrameWorkClient();
        $this->log4p = new Log4p();
    }

    public function getReflectionClass(Response $response, string $class): ReflectionClass
    {
        try {
            $class = new ReflectionClass($class);
        }catch (ReflectionException $exception){
            $this->log4p->muix_log_warn(__CLASS__,__METHOD__,__LINE__,$exception->getMessage());
            $response->doExceptionResponse(new ServerException(),500);
        }
        return $class;
    }

    public function getControllerInstance(Response $response, ReflectionClass $reflectionClass): mixed
    {
        try {
            $instance = $reflectionClass->newInstance();
        }catch (ReflectionException $exception){
            $this->log4p->muix_log_warn(__CLASS__,__METHOD__,__LINE__,$exception->getMessage());
            $response->doExceptionResponse(new ServerException(),500);
        }
        return $instance;
    }

    public function injectRR(Request $request, Response $response, ReflectionClass $reflectionClass,mixed $instance): void
    {
        try {
            $request_property = $reflectionClass->getProperty("request");
            $request_property->setValue($instance,$request);

            $response_property = $reflectionClass->getProperty("response");
            $response_property->setValue($instance,$response);
        }
        catch (ReflectionException $exception) {
            $this->log4p->muix_log_warn(__CLASS__,__METHOD__,__LINE__,$exception->getMessage());
        }
    }

    public function getControllerHandle(Response $response,ReflectionClass $reflectionClass, string $handle): ReflectionMethod
    {
        try {
            $method = $reflectionClass->getMethod($handle);
        }catch (ReflectionException $exception) {
            $this->log4p->muix_log_warn(__CLASS__,__METHOD__,__LINE__,$exception->getMessage());
            $response->doExceptionResponse(new ServerException(),500);
        }
        return $method;
    }

    public function handleExecutor(Response $response,mixed $instance, ReflectionMethod $method, array $argv): mixed
    {
        try {
            $returnData = $this->frameWorkClient->aopExecutor($instance,$method,$argv);
        }catch (ReflectionException $exception) {
            $this->log4p->muix_log_warn(__CLASS__,__METHOD__,__LINE__,$exception->getMessage());
            $response->doExceptionResponse(new ServerException(),500);
        }
        return $returnData;
    }
}