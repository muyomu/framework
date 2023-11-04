<?php

namespace muyomu\data\connector;

use muyomu\data\annotation\Repository;
use muyomu\data\client\ResultClient;
use muyomu\data\client\TransactionClient;
use muyomu\data\exception\AttributeNotTagException;
use muyomu\data\exception\MysqlConfigNotMatch;
use muyomu\data\exception\MysqlConnectException;
use muyomu\data\Result\Mode;
use muyomu\data\utility\SqlConnectorForPdo;
use muyomu\data\utility\SqlExecutorForPdo;
use muyomu\data\utility\SqlTransactionForPdo;
use muyomu\data\utility\TableUtility;
use muyomu\log4p\Log4p;
use PDO;
use PDOStatement;
use ReflectionClass;
use ReflectionException;

class PdoMysql implements TransactionClient, ResultClient
{
    private SqlExecutorForPdo $sqlExecutor;

    private SqlTransactionForPdo $sqlTransactionForPdo;

    private ReflectionClass $tableClass;

    private PDO $connection;

    private PDOStatement | bool $statement;

    /**
     * @throws MysqlConfigNotMatch
     * @throws MysqlConnectException
     * @throws ReflectionException
     */
    public function __construct(string $databaseDomain)
    {
        $this->sqlExecutor = new SqlExecutorForPdo();

        $this->sqlTransactionForPdo = new SqlTransactionForPdo();

        $log4p = new Log4p();

        $this->tableClass = TableUtility::getReflectClass($databaseDomain);

        //数据连接工具
        $mysqlDataBase = new SqlConnectorForPdo();

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
        return $this->sqlTransactionForPdo->transaction($this->connection);
    }

    /**
     * @throws ReflectionException|AttributeNotTagException
     */
    public function query(string $method, array $args): void
    {
        $methodInstance = $this->tableClass->getMethod($method);

        $this->statement = $this->sqlExecutor->sqlExecutor($this->connection,$this->tableClass->newInstance(),$methodInstance,$args);
    }

    /**
     * @return bool
     */
    public function rollback(): bool
    {
        return $this->sqlTransactionForPdo->rollback($this->connection);
    }

    /**
     * @return bool
     */
    public function commit(): bool
    {
        return $this->sqlTransactionForPdo->commit($this->connection);
    }

    /**
     * @param Mode $mode
     * @return bool|int|array
     */
    public function getResult(Mode $mode): bool|int|array
    {
        if ($mode == Mode::RESULT_SET){
            return $this->statement->fetchAll(PDO::FETCH_ASSOC);
        }elseif ($mode == Mode::RESULT_ROW){
            return $this->statement->rowCount();
        }else{
            if ($this->statement){
                return true;
            }else{
                return $this->statement;
            }
        }
    }
}