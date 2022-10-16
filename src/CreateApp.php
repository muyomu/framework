<?php

namespace muyomu\framework;

use muyomu\framework\constraint\Serve;
use muyomu\http\Request;
use muyomu\http\Response;
use muyomu\router\exception\RuleNotMatch;
use muyomu\router\RouterClient;

class CreateApp implements Serve
{
    private Request $request;

    private Response $response;

    public function __construct(){
        $this->request = new Request();
        $this->response = new Response();
    }

    /**
     * @throws RuleNotMatch
     */
    public function run():void{
        $document = RouterClient::getRule($this->request->getURL());
        $rule =$document->getData();

        echo  $rule->getController();
        echo $rule->getMethod();

    }

    public function __destruct()
    {
        // TODO: Implement __destruct() method.
    }
}