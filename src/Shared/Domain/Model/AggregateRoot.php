<?php

declare(strict_types=1);

namespace ECommerce\Shared\Domain\Model;

use ECommerce\Shared\Domain\Event\DomainEvent;

class AggregateRoot
{
    /**
     * @var array<DomainEvent>
     */
    private array $domainEvents = [];

    /**
     * @return array<DomainEvent>
     */
    final public function pullDomainEvents(): array
    {
        $domainEvents = $this->domainEvents;

        $this->domainEvents = [];

        return $domainEvents;
    }

    protected function recordThat(DomainEvent $event): void
    {
        $this->domainEvents[] = $event;
    }
}
