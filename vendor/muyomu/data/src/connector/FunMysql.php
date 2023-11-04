<?php

namespace muyomu\data\connector;

use muyomu\data\annotation\Repository;
use muyomu\data\client\ResultClient;
use muyomu\data\client\TransactionClient;
use muyomu\data\exception\MysqlConfigNotMatch;
use muyomu\data\exception\MysqlConnectException;
use muyomu\data\Result\Mode;
use muyomu\data\utility\SqlConnectorForFun;
use muyomu\data\utility\SqlExecutorForFun;
use muyomu\data\utility\SqlTransactionForFun;
use muyomu\data\utility\TableUtility;
use muyomu\log4p\Log4p;
use mysqli;
use mysqli_result;
use ReflectionClass;
use ReflectionException;

class FunMysql implements TransactionClient, ResultClient {

    private SqlExecutorForFun $sqlExecutor;

    private SqlTransactionForFun $sqlTransactionForFun;

    private ReflectionClass $tableClass;

    private mysqli $connection;

    private mysqli_result | bool $result;

    /**
     * @throws MysqlConfigNotMatch
     * @throws MysqlConnectException
     * @throws ReflectionException
     */
    public function __construct(string $databaseDomain)
    {
        $this->sqlExecutor = new SqlExecutorForFun();

        $this->sqlTransactionForFun = new SqlTransactionForFun();

        $log4p = new Log4p();

        $this->tableClass = TableUtility::getReflectClass($databaseDomain);

        //数据连接工具
        $mysqlDataBase = new SqlConnectorForFun();

        $repository = $this->tableClass->getAttributes(Repository::class);

        if (empty($repository)){

            $log4p->muix_log_warn(__CLASS__,__METHOD__,__LINE__,"Please determine which datasource to connect");
            throw new MysqlConnectException();
        }else{
            $dataSource = $repository[0]->newInstance()->getDataSource();

            $this->connection = $mysqlDataBase->initDataBase($dataSource);
        }
    }

    /**
     * @return bool
     */
    public function transaction(): bool
    {
        return $this->sqlTransactionForFun->transaction($this->connection);
    }

    /**
     * @throws ReflectionException
     */
    public function query(string $method, array $args):void
    {
        $methodInstance = $this->tableClass->getMethod($method);

        $this->result = $this->sqlExecutor->sqlExecutor($this->connection,$this->tableClass->newInstance(),$methodInstance,$args);
    }

    /**
     * @param Mode $mode
     * @return bool|int|array
     */
    public function getResult(Mode $mode): bool|int|array
    {
        if ($mode == Mode::RESULT_SET){
            return mysqli_fetch_all($this->result,MYSQLI_ASSOC);
        }elseif ($mode == Mode::RESULT_ROW){
            return mysqli_affected_rows($this->connection);
        }else{
            return $this->result;
        }
    }

    /**
     * @return bool
     */
    public function rollback(): bool
    {
        return $this->sqlTransactionForFun->rollback($this->connection);
    }

    /**
     * @return bool
     */
    public function commit(): bool
    {
        return $this->sqlTransactionForFun->commit($this->connection);
    }
}