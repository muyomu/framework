<?php

namespace muyomu\log4p;

use muyomu\config\ConfigParser;
use muyomu\config\exception\FieldConfigException;
use muyomu\log4p\client\LogClient;
use muyomu\log4p\config\Log4pDefaultConfig;
use muyomu\log4p\exception\LogFileOpenFailedException;
use muyomu\log4p\utility\LogUtility;

class Log4p implements LogClient
{
    private array $configData;

    private LogUtility $utility;

    /**
     * @throws FieldConfigException
     */
    public function __construct()
    {
        $parser = new ConfigParser();
        $this->configData = $parser->getConfigData(Log4pDefaultConfig::class);
        $this->utility = new LogUtility();
    }

    /**
     * @throws LogFileOpenFailedException
     */
    public function muix_log_error(string $className,string $method,int $line,string $message):void{
        $date = $this->utility->getData();
        $log = fopen($this->configData['log_location'].date("Ymd").".log","a+");
        if ($log){
            fputs($log,"[$date] [ERROR]:    ".$className.":".$method.":"."$line". "   $message"."\r\n");
        }
        else{
            throw new LogFileOpenFailedException(realpath($this->configData['log_location']));
        }
        fclose($log);
    }

    /**
     * @throws LogFileOpenFailedException
     */
    public function muix_log_warn(string $className, string $method, string $message):void{
        $date = $this->utility->getData();
        $log = fopen($this->configData['log_location'].date("Ymd").".log","a+");
        if ($log){
            fputs($log,"[$date] [WARN]:    ".$className.":".$method.":"."   $message"."\r\n");
        }
        else{
            throw new LogFileOpenFailedException(realpath($this->configData['log_location']));
        }
        fclose($log);
    }

    /**
     * @throws LogFileOpenFailedException
     */
    public function muix_log_info(string $item, mixed $message):void{
        $date = $this->utility->getData();
        $log = fopen($this->configData['log_location'].date("Ymd").".log","a+");
        if ($log){
            fputs($log,"[$date] [INFO]:    ".$item." : ".$message);
        }
        else{
            throw new LogFileOpenFailedException(realpath($this->configData['log_location']));
        }
        fclose($log);
    }

    /**
     * @throws LogFileOpenFailedException
     */
    public function muix_log_debug(string $varName, mixed $value): void
    {
        $date = $this->utility->getData();
        $log = fopen($this->configData['log_location'].date("Ymd").".log","a+");
        if ($log){
            fputs($log,"[$date] [DEBUG]:    ".$varName." : ".$value);
        }
        else{
            throw new LogFileOpenFailedException(realpath($this->configData['log_location']));
        }
        fclose($log);
    }
}