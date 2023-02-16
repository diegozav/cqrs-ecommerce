<?php

declare(strict_types=1);

namespace ECommerce\Users\Domain\Event;

use ECommerce\Shared\Domain\Event\DomainEvent;

final readonly class UserCreated extends DomainEvent
{
    private const QUALIFIED_NAME = 'core.user.created';

    private function __construct(
        string $aggregateId,
        public string $name,
        public string $email,
        string $eventId = null,
        string $occurredOn = null
    ) {
        parent::__construct($aggregateId, $eventId, $occurredOn);
    }

    public static function occur(string $aggregateId, string $name, string $email): self
    {
        return new self($aggregateId, $email, $name);
    }

    public static function unserialize(
        string $aggregateId,
        string $eventId,
        string $occurredOn,
        array $payload
    ): self {
        return new self($aggregateId, $payload['name'], $payload['email'], $eventId, $occurredOn);
    }

    public static function eventName(): string
    {
        return self::QUALIFIED_NAME;
    }

    protected function serializePayload(): array
    {
        return [
            'name' => $this->name,
            'email' => $this->email,
        ];
    }
}
