<?php

namespace muyomu\http\utility;

use muyomu\http\client\AttributeClient;

class Attribute implements AttributeClient
{
    private array $database = array();

    public function setAttribute(string $key, mixed $value): bool
    {
        $this->database[$key] = $value;
        return true;
    }

    public function getAttribute(string $key): mixed
    {
        if (array_key_exists($key,$this->database)){
            return $this->database[$key];
        }else{
            return null;
        }
    }
}