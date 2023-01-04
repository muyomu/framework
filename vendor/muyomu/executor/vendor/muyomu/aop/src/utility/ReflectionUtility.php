<?php

namespace muyomu\aop\utility;

use Exception;
use muyomu\aop\advicetype\AfterAdvice;
use muyomu\aop\advicetype\BeforeAdvice;
use muyomu\aop\advicetype\BeforeCatchAdvice;
use muyomu\aop\advicetype\BeforeReturnAdvice;
use muyomu\aop\advicetype\HystrixAdvice;
use muyomu\aop\advicetype\RoundAdvice;
use muyomu\aop\exception\AopException;
use ReflectionClass;
use ReflectionException;
use ReflectionMethod;

class ReflectionUtility
{
    /**
     * @throws AopException
     */
    public function getReflectionClass(string $className): ReflectionClass{
        try {
            $reflectionClass = new ReflectionClass($className);
        }catch (ReflectionException $exception){
            throw new AopException();
        }
        return $reflectionClass;
    }

    /**
     * @throws AopException
     */
    public function getReflectionMethod(ReflectionClass $reflectionClass, string $method): ReflectionMethod{
        try {
            $reflectionMethod = $reflectionClass->getMethod($method);
        }catch (ReflectionException $exception){
            throw new AopException();
        }
        return $reflectionMethod;
    }

    /**
     * @throws ReflectionException
     */
    public function adviceResolverHandle(object $instance, ReflectionMethod $reflectionMethod, array $args):mixed{
        $Hystrix = $reflectionMethod->getAttributes(HystrixAdvice::class);

        $beforeAdvice = $reflectionMethod->getAttributes(BeforeAdvice::class);
        if (!empty($beforeAdvice)){
            $beforeAdviceInstance = $beforeAdvice[0]->newInstance()->getInstance();
        }

        $afterAdvice = $reflectionMethod->getAttributes(AfterAdvice::class);
        if (!empty($afterAdvice)){
            $afterAdviceInstance = $afterAdvice[0]->newInstance()->getInstance();
        }

        $roundAdvice = $reflectionMethod->getAttributes(RoundAdvice::class);
        if (!empty($roundAdvice)){
            $roundAdviceInstance = $roundAdvice[0]->newInstance()->getInstance();
        }

        $beforeCatchAdvice = $reflectionMethod->getAttributes(BeforeCatchAdvice::class);
        if (!empty($beforeCatchAdvice)){
            $beforeCatchAdviceInstance = $beforeCatchAdvice[0]->newInstance()->getInstance();
        }

        $beforeReturnAdvice = $reflectionMethod->getAttributes(BeforeReturnAdvice::class);
        if (!empty($beforeReturnAdvice)){
            $beforeReturnAdviceInstance = $beforeReturnAdvice[0]->newInstance()->getInstance();
        }

        try {
            if (isset($roundAdviceInstance)){
                $roundAdviceInstance->roundAdvice();
                $result = $reflectionMethod->invokeArgs($instance,$args);
                $roundAdviceInstance->roundAdvice();
            }else{
                if (isset($beforeAdviceInstance)){
                    $beforeAdviceInstance->beforeAdvice();
                }

                $result = $reflectionMethod->invokeArgs($instance,$args);

                if (isset($afterAdviceInstance)){
                    $afterAdviceInstance->afterAdvice();
                }

            }
            goto here;

        }catch (Exception $exception){
            if (isset($beforeCatchAdviceInstance)){
                $beforeCatchAdviceInstance->beforeCatchAdvice();
            }
            if(!empty($Hystrix)){
                $HystrixAdviceInstance = $Hystrix[0]->newInstance()->getInstance();
                return $HystrixAdviceInstance->hystrixAdvice();
            }else{
                throw $exception;
            }
        }

        here:
        if (isset($beforeReturnAdviceInstance)){
            $beforeReturnAdviceInstance->beforeReturnAdvice();
        }
        return $result;
    }
}