<?php

namespace muyomu\data\utility;

use muyomu\data\annotation\Query;
use muyomu\data\exception\AttributeNotTagException;
use ReflectionException;
use ReflectionMethod;

class SqlUtility
{
    /**
     * @param object $class
     * @param ReflectionMethod $method
     * @param array $args
     * @return string
     * @throws AttributeNotTagException
     * @throws ReflectionException
     */
    public function getSql(object $class, ReflectionMethod $method, array $args): string
    {
        //执行函数验证
        $values = $method->invokeArgs($class, $args);

        //获取到所有参数
        $parameters = $method->getParameters();

        //获取函数fields
        $fields = $this->getFields($parameters);

        //获取填充sql
        return $this->fillSql($fields,$values,$method);
    }

    /**
     * @param array $parameters
     * @return array
     */
    private function getFields(array $parameters):array{

        $fields = array();

        foreach ($parameters as $parameter ){
            $fields[] = $parameter->getName();
        }

        return $fields;
    }

    /**
     * @throws AttributeNotTagException
     */
    private function fillSql(array $fields, array $args, ReflectionMethod $method):string{

        $sql = $method->getAttributes(Query::class);

        if(empty($sql)){
            throw new AttributeNotTagException();
        }else{
            $sqlString = $sql[0]->newInstance()->getSql();
        }

        foreach ($fields as $field) {
            $sqlString = str_replace(":" . $field, $args[$field], $sqlString);
        }

        return $sqlString;
    }
}