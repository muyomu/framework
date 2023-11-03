<?php

namespace muyomu\executor\utility;

use muyomu\executor\annotation\Para;
use muyomu\executor\exception\ParaMissException;
use muyomu\executor\exception\UnKnownPara;
use ReflectionMethod;

class ParaResolve
{
    /**
     * @throws ParaMissException
     * @throws UnKnownPara
     */
    public function resolvePara(ReflectionMethod $method):array{

        $options = array();

        $parameters = $method->getParameters();

        foreach ($parameters as $parameter){

            $ReflectParameters =$parameter->getAttributes(Para::class);

            if (empty($ReflectParameters)){

                throw new UnKnownPara("UnKnownPara");

            }else{
                $instance = $ReflectParameters[0]->newInstance();

                $name = $instance->getName();

                $range = $instance->getRange();

                switch ($range){
                    case "get": $options[] = $this->getPara($name);break;

                    case "post":$options[] = $this->postPara($name);break;

                    case "file":$options[] = $this->filePara($name);break;
                }
            }
        }
        return $options;
    }

    /**
     * @throws ParaMissException
     */
    private function getPara(string $name):mixed{
        if (isset($_GET[$name])){
            return $_GET[$name];
        }else{
            throw new ParaMissException("Para missing:".$name);
        }
    }

    /**
     * @throws ParaMissException
     */
    private function postPara(string $name):mixed{
        if (isset($_POST[$name])){
            return $_POST[$name];
        }else{
            throw new ParaMissException("Para missing:".$name);
        }
    }

    /**
     * @throws ParaMissException
     */
    private function filePara(string $name):mixed{
        if (isset($_FILES[$name])){
            return $_FILES[$name];
        }else{
            throw new ParaMissException("Para missing:".$name);
        }
    }
}