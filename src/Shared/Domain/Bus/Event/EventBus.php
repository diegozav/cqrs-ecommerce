<?php

declare(strict_types=1);

namespace ECommerce\Shared\Domain\Bus\Event;

use ECommerce\Shared\Domain\Event\DomainEvent;

interface EventBus
{
    public function publish(DomainEvent ...$domainEvents): void;
}
