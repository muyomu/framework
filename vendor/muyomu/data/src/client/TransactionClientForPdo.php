<?php

namespace muyomu\data\client;

use PDO;

interface TransactionClientForPdo
{
    public function transaction(PDO $con):bool;

    public function rollback(PDO $con):bool;

    public function commit(PDO $con):bool;
}