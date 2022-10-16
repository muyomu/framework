<?php

namespace muyomu\dpara\client;

use muyomu\http\Request;

interface Dpara
{
    public function dpara(Request $request):void;
}