<?php
namespace muyomu\punit\generic;

interface TestCase{
    public function Test(mixed $instanceOrClassname,string $method,array $args):mixed;
}

