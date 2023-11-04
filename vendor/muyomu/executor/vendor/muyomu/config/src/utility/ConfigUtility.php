<?php

namespace muyomu\config\utility;

use muyomu\config\client\UtilityClient;
use ReflectionAttribute;
use ReflectionClass;
use ReflectionException;

class ConfigUtility implements UtilityClient
{

    /**
     * @param string $className
     * @return ReflectionClass|null
     */
    public function getConfigClassInstance(string $className): ReflectionClass | null
    {

        try {
            $reflectionClass = new ReflectionClass($className);
        }catch (ReflectionException){
            return null;
        }
        return $reflectionClass;
    }

    /**
     * @param ReflectionClass $reflectionClass
     * @param string $attributeClass
     * @return ReflectionAttribute|null
     */
    public function getAttributeClassInstance(ReflectionClass $reflectionClass, string $attributeClass): ReflectionAttribute | null
    {
        $attributes = $reflectionClass->getAttributes($attributeClass);
        if (empty($attributes)){
            return null;
        }else{
            return $attributes[0];
        }
    }
}