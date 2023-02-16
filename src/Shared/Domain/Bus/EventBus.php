<?php

namespace ECommerce\Shared\Domain\Bus;

use ECommerce\Shared\Domain\Event\DomainEvent;

interface EventBus
{
    public function publish(DomainEvent ...$domainEvents): void;
}
