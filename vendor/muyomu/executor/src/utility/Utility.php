<?php

namespace muyomu\executor\utility;

use Exception;
use muyomu\aop\FrameworkExecutor;
use muyomu\executor\client\ExecutorHelper;
use muyomu\http\Request;
use muyomu\http\Response;
use muyomu\log4p\Log4p;
use ReflectionClass;
use ReflectionException;
use ReflectionMethod;

class Utility implements ExecutorHelper
{
    private FrameworkExecutor $frameWorkClient;

    public function __construct()
    {
        $this->frameWorkClient = new FrameworkExecutor();
    }


    /**
     * @param Response $response
     * @param string $class
     * @return ReflectionClass
     */
    public function getReflectionClass(Response $response, string $class): ReflectionClass
    {
        try {
            $class = new ReflectionClass($class);
        }catch (ReflectionException $exception){
             Log4p::framework_log_error(__CLASS__,__METHOD__,__LINE__,$exception->getMessage());
        }
        return $class;
    }

    /**
     * @param Response $response
     * @param ReflectionClass $reflectionClass
     * @return mixed
     */
    public function getControllerInstance(Response $response, ReflectionClass $reflectionClass): mixed
    {
        try {
            $instance = $reflectionClass->newInstance();
        }catch (ReflectionException $exception){
            Log4p::framework_log_error(__CLASS__,__METHOD__,__LINE__,$exception->getMessage());
        }
        return $instance;
    }

    /**
     * @param Request $request
     * @param Response $response
     * @param ReflectionClass $reflectionClass
     * @param mixed $instance
     * @return void
     */
    public function injectRR(Request $request, Response $response, ReflectionClass $reflectionClass, mixed $instance): void
    {
        try {
            $request_property = $reflectionClass->getProperty("request");
            $request_property->setValue($instance,$request);

            $response_property = $reflectionClass->getProperty("response");
            $response_property->setValue($instance,$response);
        }
        catch (ReflectionException $exception) {
            Log4p::framework_log_error(__CLASS__,__METHOD__,__LINE__,$exception->getMessage());
        }
    }

    /**
     * @param ReflectionClass $reflectionClass
     * @param string $handle
     * @return ReflectionMethod
     */
    public function getControllerHandle(ReflectionClass $reflectionClass, string $handle): ReflectionMethod
    {
        try {
            $method = $reflectionClass->getMethod($handle);
        }catch (ReflectionException $exception) {
            Log4p::framework_log_error(__CLASS__,__METHOD__,__LINE__,$exception->getMessage());
        }
        return $method;
    }

    /**
     * @param mixed $instance
     * @param ReflectionMethod $method
     * @param array $argv
     * @return mixed
     */
    public function handleExecutor(mixed $instance, ReflectionMethod $method, array $argv): mixed
    {
        try {
            $returnData = $this->frameWorkClient->aopExecutor($instance,$method,$argv);
        }catch (Exception $exception) {
            Log4p::framework_log_error(__CLASS__,__METHOD__,__LINE__,$exception->getMessage());
        }
        return $returnData;
    }
}