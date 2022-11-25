<?php

namespace muyomu\database\base;

class Document
{
    private mixed $dataType;

    private mixed $data;

    /**
     * @param mixed $data
     */
    public function __construct(mixed $data)
    {
        $this->dataType = gettype($data);
        $this->data = $data;
    }

    /**
     * @return string
     */
    public function getDataType(): string
    {
        return $this->dataType;
    }


    /**
     * @return mixed
     */
    public function getData(): mixed
    {
        return $this->data;
    }

    /**


    /**
     * @param mixed $data
     */
    public function setData(mixed $data): void
    {
        $this->data = $data;
    }
}