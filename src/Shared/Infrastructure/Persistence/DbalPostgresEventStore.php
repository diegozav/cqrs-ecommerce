<?php

declare(strict_types=1);

namespace ECommerce\Shared\Infrastructure\Persistence;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Exception;
use ECommerce\Shared\Domain\Event\DomainEvent;
use ECommerce\Shared\Domain\Event\EventStore;
use ECommerce\Shared\Domain\Exception\EventStoreNotAvailableException;
use ECommerce\Shared\Infrastructure\Bus\Event\DomainEventLocator;

use function Lambdish\Phunctional\map;

final readonly class DbalPostgresEventStore implements EventStore
{
    private const TABLE_NAME = 'event_store';

    public function __construct(
        private Connection $connection,
        private DomainEventLocator $domainEventLocator,
    ) {
    }

    public function append(DomainEvent $event): void
    {
        try {
            $this->connection->insert(self::TABLE_NAME, [
                'uuid' => $event->eventId,
                'name' => $event::eventName(),
                'aggregate_id' => $event->aggregateId,
                'occurred_on' => $event->occurredOn,
                'payload' => json_encode($event->serialize()),
            ]);
        } catch (Exception) {
            throw EventStoreNotAvailableException::default();
        }
    }

    public function allStoredEventsSince(string $eventId): array
    {
        try {
            $rawEvent = $this->connection->createQueryBuilder()
                ->select('id')
                ->from(self::TABLE_NAME)
                ->where('uuid', $eventId)
                ->fetchOne();

            if (! $rawEvent) {
                return [];
            }

            $rawEvents = $this->connection->createQueryBuilder()
                ->select('*')
                ->from(self::TABLE_NAME)
                ->where('id', '>', $rawEvent->id)
                ->fetchAllAssociative();

            return map($this->transformToDomainEvent(), $rawEvents);
        } catch (Exception) {
            throw EventStoreNotAvailableException::default();
        }
    }

    private function transformToDomainEvent(): callable
    {
        return function (array $rawEvent) {
            $domainEvent = $this->domainEventLocator->fromName($rawEvent['name']);

            return $domainEvent::unserialize(
                $rawEvent['aggregate_id'],
                json_decode($rawEvent['payload'], true),
                $rawEvent['uuid'],
                $rawEvent['occurred_on']
            );
        };
    }
}
