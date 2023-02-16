<?php

declare(strict_types=1);

namespace ECommerce\Shared\Domain\Bus\Event;

use ECommerce\Shared\Domain\Event\DomainEvent;
use ECommerce\Shared\Domain\Event\EventStore;

final readonly class SimpleEventBus implements EventBus
{
    public function __construct(
        private EventStore $eventStore
    ) {
    }

    public function publish(DomainEvent ...$domainEvents): void
    {
        foreach ($domainEvents as $domainEvent) {
            $this->eventStore->append($domainEvent);
        }
    }
}
