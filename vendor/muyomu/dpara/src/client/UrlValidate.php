<?php

namespace muyomu\dpara\client;

use muyomu\database\base\Document;
use muyomu\http\Request;
use muyomu\http\Response;

interface UrlValidate
{
    public function key_exits(string $key, array $database,Request $request,Response $response,array $dbClient,array &$keyCollector,array &$dataCollector): Document |null;

    public function get_next_url(string $url, array &$dataCollector,Response $response): string;

    public function get_combined_url(array $items):string;
}