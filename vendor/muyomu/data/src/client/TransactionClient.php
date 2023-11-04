<?php

namespace muyomu\data\client;

interface TransactionClient
{
    public function transaction():bool;

    public function rollback():bool;

    public function commit():bool;
}