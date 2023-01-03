<?php

namespace muyomu\inject\utility;

use muyomu\inject\annotation\AutoWired;
use muyomu\inject\annotation\Value;
use muyomu\inject\client\InstanceClient;
use ReflectionClass;
use ReflectionException;
use ReflectionProperty;

class ReflectionTypeStrategy implements InstanceClient
{
    private string $status;

    /**
     * @param string $status
     */
    public function setStatus(string $status): void
    {
        $this->status = $status;
    }

    /**
     * @throws ReflectionException
     */
    public function getInstance(mixed $classOrInstance): object
    {
        if ($this->status == "string")
            return $this->getInstanceWithNoInstance($classOrInstance);
        else
            return $this->getInstanceWithInstance($classOrInstance::class,$classOrInstance);
    }

    /**
     * @throws ReflectionException
     */
    public function getInstanceWithNoInstance(string $className): object
    {
        $reflectionClass = new ReflectionClass($className);

        $reflectionInstance = $reflectionClass->newInstance();

        return $this->extracted($reflectionClass, $reflectionInstance);
    }

    /**
     * @throws ReflectionException
     */
    public function getInstanceWithInstance(string $className,object $instance): object
    {
        $reflectionClass = new ReflectionClass($className);

        $reflectionInstance = $instance;

        return $this->extracted($reflectionClass, $reflectionInstance);
    }

    /**
     * @throws ReflectionException
     */
    public function fillProperty(string $className, ReflectionProperty $reflectionProperty, object $instance): void
    {
        $object = $this->getInstanceWithNoInstance($className);
        $reflectionProperty->setValue($instance,$object);
    }

    /**
     * @param ReflectionClass $reflectionClass
     * @param object $reflectionInstance
     * @return object
     * @throws ReflectionException
     */
    public function extracted(ReflectionClass $reflectionClass, object $reflectionInstance): object
    {
        $properties = $reflectionClass->getProperties();

        if (!empty($properties)) {

            foreach ($properties as $property) {

                $type = $property->getType()->getName();

                $attributes = $property->getAttributes();

                if (!in_array($type, array("string", "int", "bool", "float"))) {

                    foreach ($attributes as $attribute) {
                        $attrName = $attribute->getName();
                        if ($attrName == AutoWired::class) {
                            $value = $attribute->newInstance()->getValue();
                            $this->fillProperty($value, $property, $reflectionInstance);
                        }
                    }
                } else {

                    foreach ($attributes as $attribute) {
                        $attrName = $attribute->getName();
                        if ($attrName == Value::class) {
                            $value = $attribute->newInstance()->getValue();
                            $property->setValue($reflectionInstance, $value);
                        }
                    }
                }
            }
        }
        return $reflectionInstance;
    }
}