<?php

namespace muyomu\dpara\client;

use muyomu\database\DbClient;
use muyomu\http\Request;
use muyomu\http\Response;

interface Dpara
{
    public function dpara(Request $request,Response $response,DbClient $dbClient):void;
}