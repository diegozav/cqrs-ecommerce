<?php

declare(strict_types=1);

namespace ECommerce\Shared\Infrastructure\Bus;

use ECommerce\Shared\Domain\Bus\EventBus;
use ECommerce\Shared\Domain\Event\DomainEvent;
use ECommerce\Shared\Domain\EventStore;

final readonly class DbalPostgresEventBus implements EventBus
{
    public function __construct(private EventStore $eventStore)
    {
    }

    public function publish(DomainEvent ...$domainEvents): void
    {
        foreach ($domainEvents as $domainEvent) {
            $this->eventStore->append($domainEvent);
        }
    }
}
