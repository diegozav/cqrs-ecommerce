<?php

declare(strict_types=1);

namespace ECommerce\Shared\Domain\Exception;

use DomainException;

class RepositoryNotAvailableException extends DomainException
{
    public static function default(): self
    {
        return new self('Repository not available');
    }
}
