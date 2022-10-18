<?php

namespace muyomu\dpara\client;

use muyomu\http\Request;

interface UrlValidate
{
    public function key_exits(string $key,array $database,Request $request):bool;

    public function get_next_url(string $url,array $dataCollector):string;

    public function get_combined_url(array $items):string;
}