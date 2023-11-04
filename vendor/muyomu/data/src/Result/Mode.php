<?php

namespace muyomu\data\Result;

enum Mode:int
{
    case RESULT_SET=1;
    case RESULT_ROW=2;
    case RESULT_STAT=3;
}