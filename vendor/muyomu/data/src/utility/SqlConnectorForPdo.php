<?php

namespace muyomu\data\utility;

use muyomu\data\config\DataSourceConfig;
use muyomu\data\exception\MysqlConnectException;
use muyomu\log4p\Log4p;
use mysql_xdevapi\Exception;
use PDO;

class SqlConnectorForPdo
{
    private DataSourceConfig $config;

    private Log4p $log4p;

    public function __construct(){

        $this->config = new DataSourceConfig();

        $this->log4p = new Log4p();
    }

    /**
     * @throws MysqlConnectException
     */
    public function initDataBase(string $dataSource): PDO | null
    {
        $dataSourceName = $this->config->getOptions("pool.".$dataSource);

        if ($dataSourceName == null){

            $this->log4p->muix_log_error(__CLASS__,__METHOD__,__LINE__,"Can't find the datasource");
            throw new MysqlConnectException();
        }

        try {
            return new PDO("mysql:host=".$dataSourceName['hostname'].";dbname=".$dataSourceName['database'].";port=".$dataSourceName['port'],$dataSourceName['user']['username'],$dataSourceName['user']['password']);
        }catch (Exception $exception){
            $this->log4p->muix_log_error(__CLASS__,__METHOD__,__LINE__,$exception->getMessage());
            return null;
        }
    }
}