<?php

namespace muyomu\http\message;

class Message{
    private int $dataCode;

    private string $dataStatus;

    private string $dataType;

    private mixed $data;

    /**
     * @return int
     */
    public function getDataCode(): int
    {
        return $this->dataCode;
    }

    /**
     * @param int $dataCode
     */
    public function setDataCode(int $dataCode): void
    {
        $this->dataCode = $dataCode;
    }

    /**
     * @return string
     */
    public function getDataStatus(): string
    {
        return $this->dataStatus;
    }

    /**
     * @param string $dataStatus
     */
    public function setDataStatus(string $dataStatus): void
    {
        $this->dataStatus = $dataStatus;
    }

    /**
     * @return string
     */
    public function getDataType(): string
    {
        return $this->dataType;
    }

    /**
     * @param string $dataType
     */
    public function setDataType(string $dataType): void
    {
        $this->dataType = $dataType;
    }

    /**
     * @return mixed
     */
    public function getData(): mixed
    {
        return $this->data;
    }

    /**
     * @param mixed $data
     */
    public function setData(mixed $data): void
    {
        $this->data = $data;
    }
}