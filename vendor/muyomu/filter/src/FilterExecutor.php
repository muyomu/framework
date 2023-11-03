<?php

namespace muyomu\filter;

use muyomu\filter\client\GenericFilter;
use muyomu\http\Request;
use muyomu\http\Response;

class FilterExecutor
{
    private array $filterObjects = array();

    /**
     * @param Request $request
     * @param Response $response
     * @return void
     */
    public function doFilterChain(Request $request,Response $response):void{

        if (!empty($this->filterObjects)){

            $objects = array_reverse($this->filterObjects);

            foreach ($objects as $object){

                $filter = array_pop($object);

                if (!is_null($filter)){

                    $filter->filter($request,$response);
                }
            }
        }
    }

    /**
     * @param GenericFilter $filter
     * @return void
     */
    public function addFilter(GenericFilter $filter):void{
        $this->filterObjects[] = $filter;
    }
}