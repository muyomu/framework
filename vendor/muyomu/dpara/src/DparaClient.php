<?php

namespace muyomu\dpara;

use muyomu\database\base\DataType;
use muyomu\database\base\Document;
use muyomu\database\DbClient;
use muyomu\database\exception\KeyNotFond;
use muyomu\database\exception\RepeatDefinition;
use muyomu\dpara\client\Dpara;
use muyomu\dpara\exception\UrlNotMatch;
use muyomu\http\Request;

class DparaClient implements Dpara
{
    private array $dataCollector = array();

    private DparaHelper $dparaHelper;

    public function __construct()
    {
        $this->dparaHelper = new DparaHelper();
    }


    /**
     * @throws UrlNotMatch|KeyNotFond
     * @throws RepeatDefinition
     */
    public function dpara(Request $request, DbClient $dbClient): void
    {
        /*
         * 静态路由查询
         */
        do{
            $result = $this->dparaHelper->key_exits($request->getURL(),$dbClient->database,$request);
        }
        while($result);
        //将数据保存到request中的rule中
        $request_db = $request->getDataBase()->select("rule");
        $request_db->getData()->setDpara($this->dataCollector);
    }
}