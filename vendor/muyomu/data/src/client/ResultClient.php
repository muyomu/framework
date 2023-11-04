<?php

namespace muyomu\data\client;


use muyomu\data\Result\Mode;

interface ResultClient
{
    public function getResult(Mode $mode): bool | int | array;
}