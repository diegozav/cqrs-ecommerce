<?php

declare(strict_types=1);

namespace ECommerce\Shared\Domain\Event;

use DateTimeImmutable;
use DateTimeInterface;
use Ramsey\Uuid\Uuid;

abstract readonly class DomainEvent
{
    public string $eventId;

    public string $occurredOn;

    public function __construct(
        public string $aggregateId,
        ?string $eventId = null,
        ?string $occurredOn = null,
    ) {
        $this->eventId = $eventId ?? Uuid::uuid4()->toString();
        $this->occurredOn = $occurredOn ?? (new DateTimeImmutable())->format(DateTimeInterface::ATOM);
    }

    abstract public static function eventName(): string;

    abstract public static function unserialize(
        string $aggregateId,
        string $eventId,
        string $occurredOn,
        array $payload
    ): self;

    public function serialize(): array
    {
        return [
            'aggregateId' => $this->aggregateId,
            'eventId' => $this->eventId,
            'occurredOn' => $this->occurredOn,
            'payload' => $this->serializePayload(),
        ];
    }

    abstract protected function serializePayload(): array;
}
