<?php

namespace muyomu\aop;

use Exception;
use muyomu\aop\advice\Client;
use muyomu\aop\advicetype\AfterAdvice;
use muyomu\aop\advicetype\BeforeAdvice;
use muyomu\aop\advicetype\BeforeCatchAdvice;
use muyomu\aop\advicetype\ReturnedAdvice;
use ReflectionClass;
use ReflectionException;

class AopClient implements Client
{

    /**
     * @throws ReflectionException
     */
    public function aopExecutor(string $targetClassName, string $targetHandleName,mixed $argsForAop, array $args): mixed
    {
        $class = new ReflectionClass($targetClassName);

        $instance = $class->newInstance();

        $method = $class->getMethod($targetHandleName);

        $beforeAdvice = $method->getAttributes(BeforeAdvice::class);
        $afterAdvice = $method->getAttributes(AfterAdvice::class);
        $returnedAdvice = $method->getAttributes(ReturnedAdvice::class);
        $beforeCatchAdvice = $method->getAttributes(BeforeCatchAdvice::class);

        if (!empty($beforeAdvice)){
            $advice = $beforeAdvice[0]->newInstance();
            $adviceClass = $advice->getAdviceClassName();
            $adviceClass_class = new ReflectionClass($adviceClass);
            $adviceClass_instance = $adviceClass_class->newInstance();
            $adviceClass_handle = $adviceClass_class->getMethod("beforeAdviceHandle");
            $adviceClass_handle->invoke($adviceClass_instance,$argsForAop);
        }

        try {
            $data = $method->invokeArgs($instance,$args);
        }catch (Exception $exception){
            if (!empty($beforeCatchAdvice)){
                $advice = $beforeCatchAdvice[0]->newInstance();
                $adviceClass = $advice->getAdviceClassName();
                $adviceClass_class = new ReflectionClass($adviceClass);
                $adviceClass_instance = $adviceClass_class->newInstance();
                $adviceClass_handle = $adviceClass_class->getMethod("beforeCatchAdviceHandle");
                $adviceClass_handle->invoke($adviceClass_instance,$argsForAop);
            }
            throw $exception;
        }

        if (!empty($afterAdvice)){
            $advice = $afterAdvice[0]->newInstance();
            $adviceClass = $advice->getAdviceClassName();
            $adviceClass_class = new ReflectionClass($adviceClass);
            $adviceClass_instance = $adviceClass_class->newInstance();
            $adviceClass_handle = $adviceClass_class->getMethod("afterAdviceHandle");
            $adviceClass_handle->invoke($adviceClass_instance,$argsForAop);
        }

        if (!empty($returnedAdvice)){
            $advice = $returnedAdvice[0]->newInstance();
            $adviceClass = $advice->getAdviceClassName();
            $adviceClass_class = new ReflectionClass($adviceClass);
            $adviceClass_instance = $adviceClass_class->newInstance();
            $adviceClass_handle = $adviceClass_class->getMethod("returnedAdviceHandle");
            $adviceClass_handle->invoke($adviceClass_instance,$argsForAop);
        }

        return $data;
    }
}