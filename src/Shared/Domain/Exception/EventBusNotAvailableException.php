<?php

declare(strict_types=1);

namespace ECommerce\Shared\Domain\Exception;

use DomainException;

final class EventBusNotAvailableException extends DomainException
{
    public static function default(): self
    {
        return new self('Event bus not available');
    }
}
