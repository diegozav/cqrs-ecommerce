<?php

declare(strict_types=1);

namespace ECommerce\Shared\Infrastructure\Bus\Event;

use ECommerce\Shared\Domain\Event\DomainEvent;

use RuntimeException;

use function Lambdish\Phunctional\each;

final class DomainEventLocator
{
    /**
     * @var array<string, string>
     */
    private array $domainEvents;

    public function __construct(iterable $domainEvents)
    {
        each(
            fn (DomainEvent $domainEvent) => $this->domainEvents[$domainEvent::eventName()] = $domainEvent::class,
            $domainEvents
        );
    }

    /**
     * @return class-string<DomainEvent>
     */
    public function fromName(string $name): string
    {
        if (! isset($this->domainEvents[$name])) {
            throw new RuntimeException("The Domain Event Class for <{$name}> doesn't exist.");
        }

        return $this->domainEvents[$name];
    }
}
