<?php

namespace muyomu\http\format;

use muyomu\http\client\FormatClient;

class ExceptionFormat implements FormatClient
{
    private string $dataStatus;

    private string $dataType;

    private mixed $data;

    public function __construct(string $dataStatus, string $dataType, $data)
    {
        $this->dataStatus = $dataStatus;

        $this->dataType = $dataType;

        $this->data = $data;
    }

    public function format():array{
        return array("dataStatus"=>$this->dataStatus,"dataType"=>$this->dataType,"data"=>$this->data);
    }
}