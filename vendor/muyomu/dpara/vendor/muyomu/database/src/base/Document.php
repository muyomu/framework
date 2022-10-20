<?php

namespace muyomu\database\base;

class Document
{
    private int $dataType;

    private string $createTime;

    private string $modifyTime;

    private int $version;

    private mixed $data;

    /**
     * @param int $dataType
     * @param string $createTime
     * @param string $modifyTime
     * @param int $version
     * @param mixed $data
     */
    public function __construct(int $dataType, string $createTime, string $modifyTime, int $version, mixed $data)
    {
        $this->dataType = $dataType;
        $this->createTime = $createTime;
        $this->modifyTime = $modifyTime;
        $this->version = $version;
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
     * @return string
     */
    public function getCreateTime(): string
    {
        return $this->createTime;
    }

    /**
     * @return string
     */
    public function getModifyTime(): string
    {
        return $this->modifyTime;
    }

    /**
     * @return int
     */
    public function getVersion(): int
    {
        return $this->version;
    }

    /**
     * @return mixed
     */
    public function getData(): mixed
    {
        return $this->data;
    }

    /**
     * @param string $modifyTime
     */
    public function setModifyTime(string $modifyTime): void
    {
        $this->modifyTime = $modifyTime;
    }

    /**
     * @param int $version
     */
    public function setVersion(int $version): void
    {
        $this->version = $version;
    }

    /**
     * @param mixed $data
     */
    public function setData(mixed $data): void
    {
        $this->data = $data;
    }
}