<?php

namespace muyomu\filter;

use muyomu\filter\client\GenericFilter;
use muyomu\http\Request;
use muyomu\http\Response;

class FilterExecutor
{
    private array $filterObjects = array();

    public function doFilterChain(Request $request,Response $response):void{
        if (!empty($this->filterObjects)){
            $objects = array_reverse($this->filterObjects);
            foreach ($objects as $object){
                $filter = array_pop($objects);
                if (!is_null($filter)){
                    $filter->filter($request,$response);
                }
            }
        }
    }

    public function addFilter(GenericFilter $filter):void{
        $this->filterObjects[] = $filter;
    }

}