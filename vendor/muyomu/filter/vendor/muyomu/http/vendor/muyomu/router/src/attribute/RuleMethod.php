<?php

namespace muyomu\router\attribute;

enum RuleMethod
{
    case GET;
    case POST;
    case HEAD;
    case OPTIONS;
    case PUT;
    case DELETE;
    case TRACE;
    case CONNECT;
    case PATCH;
}
