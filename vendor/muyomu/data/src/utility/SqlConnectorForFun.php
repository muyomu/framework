<?php

namespace muyomu\data\utility;

use muyomu\data\config\DataSourceConfig;
use muyomu\data\exception\MysqlConfigNotMatch;
use muyomu\data\exception\MysqlConnectException;
use muyomu\log4p\Log4p;
use mysqli;

class SqlConnectorForFun
{
    private DataSourceConfig $config;

    private Log4p $log4p;

    public function __construct(){

        $this->config = new DataSourceConfig();

        $this->log4p = new Log4p();
    }

    /**
     * @throws MysqlConfigNotMatch
     * @throws MysqlConnectException
     */
    public function initDataBase(string $dataSource): bool| mysqli
    {
        $dataSourceName = $this->config->getOptions("pool.".$dataSource);

        if ($dataSourceName == null){

            $this->log4p->muix_log_error(__CLASS__,__METHOD__,__LINE__,"Can't find the datasource");
            throw new MysqlConnectException();
        }

        $result = mysqli_connect($dataSourceName["hostname"],$dataSourceName["user"]["username"],$dataSourceName["user"]["password"],$dataSourceName["database"],$dataSourceName["port"]);

        if (!$result){
            throw new MysqlConfigNotMatch();
        }else{
            return $result;
        }
    }
}