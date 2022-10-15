<?php

namespace muyomu\framework\http;

/*
 * 请求报文
 */

use muyomu\framework\exception\HeaderNotFound;

class Request
{
    /*
     * 固定信息
     */
    public function getRequestMethod():string{
        return $_SERVER['REQUEST_METHOD'];
    }

    public function getRequestURI():string{
        return $_SERVER['REQUEST_URI'];
    }

    public function getRemoteHost():string{
        return $_SERVER['REMOTE_HOST'];
    }

    public function getRemotePort():int{
        return $_SERVER['REMOTE_PORT'];
    }

    /*
     * 动态信息
     */
    /**
     * @throws HeaderNotFound
     */
    public function getHeader(string $key):string{
        if(empty($_SERVER['HTTP_'.strtoupper($key)])){
            throw new HeaderNotFound();
        }else{
            return $_SERVER['HTTP_'.strtoupper($key)];
        }
    }
}