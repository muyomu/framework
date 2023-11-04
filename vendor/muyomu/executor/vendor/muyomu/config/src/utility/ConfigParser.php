<?php

namespace muyomu\config\utility;

use muyomu\config\annotation\Configuration;
use ReflectionClass;
use ReflectionException;

class ConfigParser
{
    private ConfigUtility $utility;

    public function __construct()
    {
        $this->utility = new ConfigUtility();
    }

    /**
     * @param string $configClassName
     * @return array
     */
    public function getConfigData(string $configClassName):array{

        $reflectionClass = $this->utility->getConfigClassInstance($configClassName);

        $attribute = $this->utility->getAttributeClassInstance($reflectionClass,Configuration::class);

        $configField = $attribute->newInstance()->getConfigField();

        if ($this->checkForField($configField)){
            $defaultData = $this->getDefaultConfigData($reflectionClass);
            $this->resolveConfigData($GLOBALS[$configField], $defaultData);
            return $defaultData;
        }else{
            return $this->getDefaultConfigData($reflectionClass);
        }
    }

    /**
     * @param string $field
     * @return bool
     */
    private function checkForField(string $field):bool{
        if (isset($GLOBALS[$field])){
            return true;
        }else{
            return false;
        }
    }

    /**
     * @param array $fieldData
     * @param array $defaultData
     */
    private function resolveConfigData(array &$fieldData, array &$defaultData):void{

        $keys = array_keys($fieldData);
        foreach ($keys as $key){
            if (isset($defaultData[$key])){
                if (is_array($defaultData[$key])){
                    if ($this->checkForAssocArray($defaultData[$key])){
                        if ($this->checkForAssocArray($fieldData[$key])){
                            $this->resolveConfigData($fieldData[$key],$defaultData[$key]);
                        }
                    }else{
                        $indexes = array_keys($fieldData[$key]);
                        foreach ($indexes as $index){
                            $defaultData[$key][$index] = $fieldData[$key][$index];
                        }
                    }
                }else{
                    if (gettype($fieldData[$key]) == gettype($defaultData[$key])){
                        $defaultData[$key] = $fieldData[$key];
                    }
                }
            }else{
                $defaultData[$key] = $fieldData[$key];
            }
        }
    }

    /**
     * @param ReflectionClass $class
     * @return array
     */
    private function getDefaultConfigData(ReflectionClass $class):array{

        try {
            $reflectionProperty = $class->getProperty("configData");

            $reflectionClassInstance = $class->newInstance();

            $configData = $reflectionProperty->getValue($reflectionClassInstance);

        }catch (ReflectionException){
            return array();
        }
        return $configData;
    }

    /**
     * @param array $item
     * @return bool
     */
    public function checkForAssocArray(array $item):bool{
        $index = 0;
        $keys = array_keys($item);
        foreach ($keys as $key){
            if ($index == $key){
                $index++;
            }else{
                return true;
            }
        }
        return false;
    }
}