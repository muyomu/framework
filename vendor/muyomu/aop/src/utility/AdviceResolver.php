<?php

namespace muyomu\aop\utility;

use Exception;
use muyomu\aop\advicetype\AfterAdvice;
use muyomu\aop\advicetype\BeforeAdvice;
use muyomu\aop\advicetype\BeforeCatchAdvice;
use muyomu\aop\advicetype\BeforeReturnAdvice;
use muyomu\aop\advicetype\RoundAdvice;
use muyomu\aop\delegate\Delegate;
use ReflectionException;
use ReflectionMethod;

class AdviceResolver
{
    /**
     * @throws ReflectionException|Exception
     */
    public function adviceResolverHandle(object $instance, ReflectionMethod $reflectionMethod, array $args):mixed{

        $agencyAdvice = $reflectionMethod->getAttributes(Delegate::class);
        if (!empty($agencyAdvice)){
            $instanceAgencyAdvice = $agencyAdvice[0]->newInstance();
            $agencyAdviceInstance = $instanceAgencyAdvice->getInstance();
            $agencyAdviceInstanceConfig = $instanceAgencyAdvice->getConfig();
        }

        $beforeAdvice = $reflectionMethod->getAttributes(BeforeAdvice::class);
        if (!empty($beforeAdvice)){
            $instanceBeforeAdvice = $beforeAdvice[0]->newInstance();
            $beforeAdviceInstance = $instanceBeforeAdvice->getInstance();
            $beforeAdviceInstanceConfig = $instanceBeforeAdvice->getConfig();
        }

        $afterAdvice = $reflectionMethod->getAttributes(AfterAdvice::class);
        if (!empty($afterAdvice)){
            $instanceAfterAdvice = $afterAdvice[0]->newInstance();
            $afterAdviceInstance = $instanceAfterAdvice->getInstance();
            $afterAdviceInstanceConfig = $instanceAfterAdvice->getConfig();
        }

        $roundAdvice = $reflectionMethod->getAttributes(RoundAdvice::class);
        if (!empty($roundAdvice)){
            $instanceRoundAdvice = $roundAdvice[0]->newInstance();
            $roundAdviceInstance = $instanceRoundAdvice->getInstance();
            $roundAdviceInstanceConfig = $instanceRoundAdvice->getConfig();
        }

        $beforeCatchAdvice = $reflectionMethod->getAttributes(BeforeCatchAdvice::class);
        if (!empty($beforeCatchAdvice)){
            $instanceBeforeCatchAdvice = $beforeCatchAdvice[0]->newInstance();
            $beforeCatchAdviceInstance = $instanceBeforeCatchAdvice->getInstance();
            $beforeCatchAdviceInstanceConfig = $instanceBeforeCatchAdvice->getConfig();
        }

        $beforeReturnAdvice = $reflectionMethod->getAttributes(BeforeReturnAdvice::class);
        if (!empty($beforeReturnAdvice)){
            $instanceBeforeReturnAdviceInstance = $beforeReturnAdvice[0]->newInstance();
            $beforeReturnAdviceInstance = $instanceBeforeReturnAdviceInstance->getInstance();
            $beforeReturnAdviceInstanceConfig = $instanceBeforeReturnAdviceInstance->getConfig();
        }

        try {
            if (isset($roundAdviceInstance)){

                $roundAdviceInstance->roundAdvice($roundAdviceInstanceConfig);

                $result = $reflectionMethod->invokeArgs($instance,$args);

                $roundAdviceInstance->roundAdvice($roundAdviceInstanceConfig);
            }else{
                if (isset($beforeAdviceInstance)){
                    $beforeAdviceInstance->beforeAdvice($beforeAdviceInstanceConfig);
                }

                $result = $reflectionMethod->invokeArgs($instance,$args);

                if (isset($afterAdviceInstance)){
                    $afterAdviceInstance->afterAdvice($beforeAdviceInstanceConfig);
                }

            }
            goto here;

        }catch (Exception){
            if (isset($beforeCatchAdviceInstance)){
                $beforeCatchAdviceInstance->beforeCatchAdvice($beforeCatchAdviceInstanceConfig);
            }

            if(isset($agencyAdviceInstance)){
                return $agencyAdviceInstance->delegateAdvice($agencyAdviceInstanceConfig);
            }
        }

        here:
        if (isset($beforeReturnAdviceInstance)){
            $beforeReturnAdviceInstance->beforeReturnAdvice($beforeReturnAdviceInstanceConfig);
        }
        return $result;
    }
}