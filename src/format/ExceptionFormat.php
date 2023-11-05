<?php

namespace muyomu\framework\format;

use muyomu\http\client\FormatClient;

class ExceptionFormat implements FormatClient
{
    private int $code;

    private string $dataStatus;

    private string $dataType;

    private mixed $data;

    /**
     * @param int $code
     * @param string $dataStatus
     * @param string $dataType
     * @param $data
     */
    public function __construct(int $code, string $dataStatus, string $dataType, $data)
    {
        $this->code = $code;

        $this->dataStatus = $dataStatus;

        $this->dataType = $dataType;

        $this->data = $data;
    }

    /**
     * @return array
     */
    public function format():array{
        return array("code"=>$this->code,"dataStatus"=>$this->dataStatus,"dataType"=>$this->dataType,"data"=>$this->data);
    }
}