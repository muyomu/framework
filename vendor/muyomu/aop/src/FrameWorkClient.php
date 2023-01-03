<?php

namespace muyomu\aop;

use Exception;
use muyomu\aop\advice\FrameWork;
use muyomu\aop\advicetype\AfterAdvice;
use muyomu\aop\advicetype\BeforeCatchAdvice;
use muyomu\aop\advicetype\BeforeReturnAdvice;
use muyomu\aop\advicetype\Hystrix;
use muyomu\aop\advicetype\RoundAdvice;
use muyomu\aop\exception\AopException;
use muyomu\aop\utility\ReflectionUtility;
use muyomu\log4p\Log4p;
use ReflectionClass;
use ReflectionException;
use ReflectionMethod;

class FrameWorkClient implements FrameWork
{
    private ReflectionUtility $reflectionUtility;

    private Log4p $log4p;

    public function __construct()
    {
        $this->reflectionUtility = new ReflectionUtility();
        $this->log4p = new Log4p();
    }

    /**
     * @throws ReflectionException|AopException
     */
    public function aopExecutor(object $instance, ReflectionMethod $method, mixed $args): mixed
    {
        $Hystrix = $method->getAttributes(Hystrix::class);

        $reflectionClass = $this->reflectionUtility->getReflectionClass($instance::class);

        $reflectionMethod = $this->reflectionUtility->getReflectionMethod($reflectionClass,$method);

        $beforeAdvice = $reflectionMethod->getAttributes(advicetype\BeforeAdvice::class);
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
            $this->log4p->muix_log_error(__CLASS__,__METHOD__,__LINE__,$exception->getMessage());
            if (isset($beforeCatchAdviceInstance)){
                $beforeCatchAdviceInstance->beforeCatchAdvice();
            }
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

        here:
        if (isset($beforeReturnAdviceInstance)){
            $beforeReturnAdviceInstance->beforeReturnAdvice();
        }
        return $result;
    }
}