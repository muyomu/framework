<?php
namespace muyomu\database;


use muyomu\database\base\Document;
use muyomu\database\client\Client;
use muyomu\database\database\Database;

class DbClient extends Database implements Client {

    /**
     * @param string $key
     * @param Document $document
     * @return void
     */
    public function insert(string $key, Document $document): void
    {
        $this->database[$key] = $document;
    }

    /**
     * @param string $key
     * @return bool
     */
    public function delete(string $key): bool
    {
        if (!array_key_exists($key,$this->database)){
            return false;
        }else{
            unset($this->database[$key]);
            return true;
        }
    }

    /**
     * @param string $key
     * @param mixed $updateData
     * @return bool
     */
    public function update(string $key, mixed $updateData): bool
    {
        if (!array_key_exists($key,$this->database)){
            return false;
        }else{
            $document = $this->select($key);
            $dataType = $document->getDataType();
            if (!$dataType == gettype($updateData)){
                return false;
            }else{
                $document->setData($updateData);
                return true;
            }
        }
    }

    /**
     * @param string $key
     * @return Document|null
     */
    public function select(string $key): Document | null
    {
        if (!array_key_exists($key,$this->database)){
            return null;
        }else{
            return $this->database[$key];
        }
    }
}