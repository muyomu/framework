<?php

use muyomu\inject\annotation\AutoWired;
use muyomu\inject\annotation\Value;
use muyomu\inject\Proxy;

include "vendor/autoload.php";

$proxy = new Proxy();

class Tk{
    #[Value("liuzhang")]
    private string $name;

    #[AutoWired(Two::class)]
    private Two $two;

    public function tk():void{
        $this->two->tw();
    }
}

class Two{
    #[Value(12)]
    private int $sex;

    public function tw():void{
        echo $this->sex;
    }
}

$ok = $proxy->getProxyInstance(Tk::class);
$ok->tk();