<?php

namespace muyomu\aop;

use Exception;
use muyomu\aop\advice\FrameWork;
use muyomu\aop\advicetype\Hystrix;
use ReflectionClass;
use ReflectionException;
use ReflectionMethod;

class FrameWorkClient implements FrameWork
{

    /**
     * @throws ReflectionException
     */
    public function aopExecutor(mixed $instance, ReflectionMethod $method, mixed $args): mixed
    {
        $Hystrix = $method->getAttributes(Hystrix::class);

        try {
            $data = $method->invokeArgs($instance,$args);
        }catch (Exception $exception){
            if(!empty($Hystrix)){
                $advice = $Hystrix[0]->newInstance();
                $adviceClass = $advice->getHystrixClassName();
                $adviceClass_class = new ReflectionClass($adviceClass);
                $adviceClass_instance = $adviceClass_class->newInstance();
                $adviceClass_handle = $adviceClass_class->getMethod("getData");
                return $adviceClass_handle->invoke($adviceClass_instance);
            }else{
                throw $exception;
            }
        }
        return $data;
    }
}