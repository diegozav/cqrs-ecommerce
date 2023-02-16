<?php

declare(strict_types=1);

namespace ECommerce\Shared\Domain\Event;

interface EventStore
{
    public function append(DomainEvent $event): void;

    /***
     * @param string $eventId
     * @return array<DomainEvent>
     */
    public function allStoredEventsSince(string $eventId): array;
}
