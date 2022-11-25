<?php
namespace muyomu\database;


use muyomu\database\base\Document;
use muyomu\database\client\Client;
use muyomu\database\database\Database;
use muyomu\database\exception\KeyNotFond;
use muyomu\database\exception\RepeatDefinition;
use muyomu\database\exception\TypeNOtMatch;

class DbClient extends Database implements Client {

    /**
     * @throws RepeatDefinition
     */
    public function insert(string $key, Document $document): bool
    {
        if (array_key_exists($key,$this->database)){
            throw new RepeatDefinition();
        }else{
            if($this->database[$key] = $document){
                return true;
            }else{
                return false;
            }
        }
    }

    /**
     * @throws KeyNotFond
     */
    public function delete(string $key): bool
    {
        if (!array_key_exists($key,$this->database)){
            throw new KeyNotFond();
        }else{
            unset($this->database[$key]);
            return true;
        }
    }

    /**
     * @throws KeyNotFond
     * @throws TypeNOtMatch
     */
    public function update(string $key, mixed $updateData): bool
    {
        if (!array_key_exists($key,$this->database)){
            throw new KeyNotFond();
        }else{
            $document = $this->select($key);
            $dataType = $document->getDataType();
            if (!$dataType == gettype($updateData)){
                throw new TypeNOtMatch();
            }else{
                $document->setData($updateData);
                return true;
            }
        }
    }

    /**
     * @throws KeyNotFond
     */
    public function select(string $key): Document
    {
        if (!array_key_exists($key,$this->database)){
            throw new KeyNotFond();
        }else{
            return $this->database[$key];
        }
    }
}