<?php

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

    public abstract static function eventName(): string;

    public static abstract function unserialize(
        string $aggregateId,
        string $eventId,
        string $occurredOn,
        array $payload
    ): self;


    protected abstract function serializePayload(): array;

    public function serialize(): array
    {
        return [
            'aggregateId' => $this->aggregateId,
            'eventId' => $this->eventId,
            'occurredOn' => $this->occurredOn,
            'payload' => $this->serializePayload(),
        ];
    }
}
