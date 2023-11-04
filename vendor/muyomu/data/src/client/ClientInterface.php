<?php

namespace muyomu\data\client;

interface ClientInterface
{
    public function oneToOne():array;

    public function oneToMany():array;

    public function manyToMany():array;
}