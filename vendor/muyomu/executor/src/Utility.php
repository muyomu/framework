<?php

namespace muyomu\executor;

use muyomu\aop\FrameWorkClient;
use muyomu\executor\client\ExecutorHelper;
use muyomu\http\Request;
use muyomu\http\Response;
use muyomu\log4p\Log4p;
use ReflectionClass;
use ReflectionException;
use ReflectionMethod;

class Utility implements ExecutorHelper
{
    private FrameWorkClient $frameWorkClient;

    public function __construct()
    {
        $this->frameWorkClient = new FrameWorkClient();
    }

    public function getReflectionClass(Response $response, string $class): ReflectionClass
    {
        try {
            $class = new ReflectionClass($class);
        }catch (ReflectionException $exception){
            Log4p::muix_log_warn($exception->getMessage(),__CLASS__,__METHOD__);
            http_header_template();
            $response->setHeader($GLOBALS['http_code'][504]);
            die();
        }
        return $class;
    }

    public function getControllerInstance(Response $response, ReflectionClass $reflectionClass): mixed
    {
        try {
            $instance = $reflectionClass->newInstance();
        }catch (ReflectionException $exception){
            Log4p::muix_log_warn($exception->getMessage(),__CLASS__,__METHOD__);
            http_header_template();
            $response->setHeader($GLOBALS['http_code'][504]);
            die();
        }
        return $instance;
    }

    public function injectRR(Request $request, Response $response, ReflectionClass $reflectionClass,mixed $instance): void
    {
        try {
            $request_property = $reflectionClass->getProperty("request");
            /** @var TYPE_NAME $request_property */
            $request_property->setAccessible(true);
            $request_property->setValue($instance,$request);

            $response_property = $reflectionClass->getProperty("response");
            /** @var TYPE_NAME $response_property */
            $response_property->setAccessible(true);
            $response_property->setValue($instance,$response);
        }
        catch (ReflectionException $exception) {
            Log4p::muix_log_warn($exception->getMessage(),__CLASS__,__METHOD__);
        }
    }

    public function getControllerHandle(Response $response,ReflectionClass $reflectionClass, string $handle): ReflectionMethod
    {
        try {
            $method = $reflectionClass->getMethod($handle);
        }catch (ReflectionException $exception) {
            Log4p::muix_log_warn($exception->getMessage(),__CLASS__,__METHOD__);
            http_header_template();
            $response->setHeader($GLOBALS['http_code'][504]);
            die();
        }
        return $method;
    }

    public function handleExecutor(Response $response,mixed $instance, ReflectionMethod $method, array $argv): mixed
    {
        try {
            $returnData = $this->frameWorkClient->aopExecutor($instance,$method,$argv);
        }catch (ReflectionException $exception) {
            Log4p::muix_log_warn($exception->getMessage(),__CLASS__,__METHOD__);
            http_header_template();
            $response->setHeader($GLOBALS['http_code'][504]);
            die();
        }
        return $returnData;
    }
}