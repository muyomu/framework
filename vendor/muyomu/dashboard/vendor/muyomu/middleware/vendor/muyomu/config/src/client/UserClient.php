<?php

namespace muyomu\config\client;

interface UserClient
{
    public function getOptions(string $option):mixed;
}