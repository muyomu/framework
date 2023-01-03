<?php

namespace muyomu\router\attribute;

enum RuleMethod: string
{
    case RULE_GET = 'GET';
    case RULE_POST = 'POST';
}
