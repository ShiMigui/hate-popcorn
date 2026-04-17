<?php

declare(strict_types=1);

namespace Hatepopcorn\Infrastructure\Database;

enum PdoExceptionCodes: string
{
    case UNIQUE_VIOLATION      = '23505';
    case FOREIGN_KEY_VIOLATION = '23503';
    case NOT_NULL_VIOLATION    = '23502';
    case CHECK_VIOLATION       = '23514';
    case EXCLUSION_VIOLATION   = '23P01';

    case CONNECTION_EXCEPTION = '08000';
    case CONNECTION_FAILURE   = '08006';

    case INVALID_TEXT_REPRESENTATION = '22P02';

    case SYNTAX_ERROR           = '42601';
    case INSUFFICIENT_PRIVILEGE = '42501';
}
