<?php

namespace muyomu\log4p\utility;

use muyomu\log4p\client\UtilityClient;

class LogUtility implements UtilityClient
{

    public function getData(): string
    {
        return date("Y-m-d H:i:s",time());
    }
}