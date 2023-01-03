<?php

namespace muyomu\database\client;

use muyomu\database\base\Document;

interface Client
{
    public function insert(string $key, Document $document):void;

    public function delete(string $key):bool;

    public function update(string $key,mixed $updateData):bool;

    public function select(string $key):Document | null;
}