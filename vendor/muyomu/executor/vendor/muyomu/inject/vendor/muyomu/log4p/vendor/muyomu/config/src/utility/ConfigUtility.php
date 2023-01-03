<?php

namespace muyomu\config\utility;

use muyomu\config\client\UtilityClient;
use ReflectionAttribute;
use ReflectionClass;
use ReflectionException;

class ConfigUtility implements UtilityClient
{

    public function getConfigClassInstance(string $className): ReflectionClass |null
    {
        $reflectionClass = null;

        try {
            $reflectionClass = new ReflectionClass($className);
        }catch (ReflectionException $exception){
            return null;
        }
        return $reflectionClass;
    }

    public function getAttributeClassInstance(ReflectionClass $reflectionClass,string $attributeClass): ReflectionAttribute |null
    {
        $attributes = $reflectionClass->getAttributes($attributeClass);
        if (empty($attributes)){
            return null;
        }else{
            return $attributes[0];
        }
    }
}