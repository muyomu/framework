<?php

namespace muyomu\framework;

use Exception;
use muyomu\http\Request;
use muyomu\http\Response;

class Framework
{
    private Request $request;

    private Response $response;

    public function __construct()
    {
        $this->request = new Request();
        $this->response = new Response();
    }

    public static function main():void{

        $framework = new Framework();
        $application = new CreateApp();

        try {
            $application->run($framework->getRequest(),$framework->getResponse());
        }catch (Exception $e){

        }
    }

    /**
     * @return Request
     */
    public function getRequest(): Request
    {
        return $this->request;
    }

    /**
     * @return Response
     */
    public function getResponse(): Response
    {
        return $this->response;
    }
}