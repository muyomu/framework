<?php

namespace muyomu\data\utility;

use muyomu\data\client\TransactionClientForFun;
use mysqli;


class SqlTransactionForFun implements TransactionClientForFun
{

    public function transaction(mysqli $con): bool
    {
        return mysqli_begin_transaction($con);
    }

    public function rollback(mysqli $con): bool
    {
        return mysqli_rollback($con);
    }

    public function commit(mysqli $con): bool
    {
        return mysqli_commit($con);
    }
}