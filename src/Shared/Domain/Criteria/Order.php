<?php

declare(strict_types=1);

namespace ECommerce\Shared\Domain\Criteria;

final readonly class Order
{
    public function __construct(
        public OrderBy $orderBy,
        public OrderType $orderType
    ) {
    }

    public static function createDesc(OrderBy $orderBy): self
    {
        return new self($orderBy, OrderType::DESC);
    }

    public static function fromValues(?string $orderBy, ?string $order): self
    {
        return null === $orderBy ? self::none() : new self(new OrderBy($orderBy), OrderType::fromValue($order));
    }

    public static function none(): self
    {
        return new self(new OrderBy(''), OrderType::NONE);
    }

    public function isNone(): bool
    {
        return $this->orderType->isNone();
    }

    public function serialize(): string
    {
        return sprintf('%s.%s', $this->orderBy->value, $this->orderType->value);
    }
}
