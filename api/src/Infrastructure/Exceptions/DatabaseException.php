<?php

declare(strict_types=1);

namespace Hatepopcorn\Infrastructure\Exceptions;

use Hatepopcorn\Infrastructure\Database\PdoExceptionCodes;

final class DatabaseException extends InfrastructureException
{
    public readonly ?PdoExceptionCodes $type;
    public readonly mixed $rawCode;

    public function __construct(\Throwable $e, string $message = 'Database Exception', int $appCode = 0)
    {
        $this->rawCode = $e->getCode();
        $this->type    = PdoExceptionCodes::tryFrom($this->rawCode);
        parent::__construct($message, $appCode, $e);
    }
}
