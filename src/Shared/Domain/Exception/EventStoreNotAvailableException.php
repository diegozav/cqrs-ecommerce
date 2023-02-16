<?php

declare(strict_types=1);

namespace ECommerce\Shared\Domain\Exception;

use DomainException;

final class EventStoreNotAvailableException extends DomainException
{
    public static function default(): self
    {
        return new self('Event store not available');
    }
}
