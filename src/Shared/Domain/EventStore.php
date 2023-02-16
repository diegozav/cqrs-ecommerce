<?php

namespace ECommerce\Shared\Domain;

use ECommerce\Shared\Domain\Event\DomainEvent;

interface EventStore
{
    public function append(DomainEvent $event): void;

    /***
     * @param string $eventId
     * @return array<DomainEvent>
     */
    public function allStoredEventsSince(string $eventId): array;
}
