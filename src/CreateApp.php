<?php

namespace muyomu\framework;

use muyomu\framework\constraint\Serve;
use muyomu\framework\http\Request;
use muyomu\framework\http\Response;
use Muyomu\Router\Router;

/**
 * 导入资源文件
 */

include "./helper/helper.php";


class CreateApp implements Serve
{
    private Request $request;

    private Response $response;

    public function __construct(){
        $this->request = new Request();
        $this->response = new Response();
    }

    public function run():void{
        echo "hello";
    }

    public function __destruct()
    {
        // TODO: Implement __destruct() method.
    }
}