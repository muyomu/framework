<?php

namespace muyomu\config\client;

use ReflectionAttribute;
use ReflectionClass;

interface UtilityClient
{
    public function getConfigClassInstance(string $className): ReflectionClass|null;

    public function getAttributeClassInstance(ReflectionClass $reflectionClass,string $attributeClass): ReflectionAttribute |null;
}