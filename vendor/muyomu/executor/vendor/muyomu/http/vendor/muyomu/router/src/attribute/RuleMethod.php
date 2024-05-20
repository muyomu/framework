<?php

namespace muyomu\router\attribute;

enum RuleMethod: string
{
    case RULE_GET = "GET";
    case RULE_POST = "POST";
    case RULE_HEAD = "HEAD";
    case RULE_OPTIONS = "OPTIONS";
    case RULE_PUT = "PUT";
    case RULE_DELETE = "DELETE";
    case RULE_TRACE = "TRACE";
    case RULE_CONNECT = "CONNECT";
    case RULE_PATCH = "PATCH";
}
