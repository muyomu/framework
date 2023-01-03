<?php

namespace muyomu\aop;

use Exception;
use muyomu\aop\advice\AopClient;
use muyomu\aop\advicetype\AfterAdvice;
use muyomu\aop\advicetype\BeforeCatchAdvice;
use muyomu\aop\advicetype\BeforeReturnAdvice;
use muyomu\aop\advicetype\RoundAdvice;
use muyomu\aop\exception\AopException;
use muyomu\aop\utility\ReflectionUtility;
use muyomu\log4p\Log4p;
use ReflectionException;

class AopExecutor implements AopClient
{
    private ReflectionUtility $reflectionUtility;

    private Log4p $log4p;

    public function __construct()
    {
        $this->reflectionUtility = new ReflectionUtility();
        $this->log4p = new Log4p();
    }

    /**
     * @throws AopException
     * @throws ReflectionException
     */
    public function aopExecutor(object $instance, string $method, array $args): mixed
    {
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
            throw new AopException();
        }

        here:
        if (isset($beforeReturnAdviceInstance)){
            $beforeReturnAdviceInstance->beforeReturnAdvice();
        }
        return $result;
    }
}