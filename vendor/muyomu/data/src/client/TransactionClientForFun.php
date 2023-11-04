<?php

namespace muyomu\data\client;

use mysqli;

interface TransactionClientForFun
{
    public function transaction(mysqli $con):bool;

    public function rollback(mysqli $con):bool;

    public function commit(mysqli $con):bool;
}