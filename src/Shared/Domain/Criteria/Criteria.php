<?php

declare(strict_types=1);

namespace ECommerce\Shared\Domain\Criteria;

final readonly class Criteria
{
    public function __construct(
        public Filters $filters,
        public Order $order,
        public ?int $offset,
        public ?int $limit
    ) {
    }

    public function hasFilters(): bool
    {
        return $this->filters->count() > 0;
    }

    public function hasOrder(): bool
    {
        return !$this->order->isNone();
    }

    public function serialize(): string
    {
        return sprintf(
            '%s~~%s~~%s~~%s',
            $this->filters->serialize(),
            $this->order->serialize(),
            $this->offset,
            $this->limit
        );
    }
}
