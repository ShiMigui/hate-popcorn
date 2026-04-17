<?php

declare(strict_types=1);

namespace Hatepopcorn\Infrastructure\Utils;

enum Type
{
    case INT;
    case BOOL;
    case FLOAT;
    case ARRAY;
    case STRING;
}
