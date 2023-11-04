<?php

namespace muyomu\data\utility;

use muyomu\data\client\TransactionClientForPdo;
use PDO;


class SqlTransactionForPdo implements TransactionClientForPdo
{

    public function transaction(PDO $con): bool
    {
        return $con->beginTransaction();
    }

    public function rollback(PDO $con): bool
    {
        return $con->rollBack();
    }

    public function commit(PDO $con): bool
    {
        return $con->commit();
    }
}