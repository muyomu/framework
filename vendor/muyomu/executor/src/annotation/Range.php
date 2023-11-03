<?php

namespace muyomu\executor\annotation;

enum Range: string
{
    case GET = "GET";
    case POST = "POST";
    case FILE = "FILE";
}
