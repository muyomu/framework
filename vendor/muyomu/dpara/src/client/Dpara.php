<?php

namespace muyomu\dpara\client;

use muyomu\database\DbClient;
use muyomu\http\Request;

interface Dpara
{
    public function dpara(Request $request,DbClient $dbClient):void;
}