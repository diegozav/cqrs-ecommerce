<?php

declare(strict_types=1);

namespace ECommerce\Shared\Domain;

use ArrayIterator;
use Countable;
use IteratorAggregate;
use RuntimeException;

abstract readonly class Collection implements Countable, IteratorAggregate
{
    public function __construct(private array $items)
    {
        $this->assertArrayIsSameInstance($items, $this->classType());
    }

    private function assertArrayIsSameInstance(array $items, string $classType): void
    {
        foreach ($items as $item) {
            if (!($item instanceof $classType)) {
                throw new RuntimeException(
                    sprintf('Item %s from collection does not have expected %s instance', $item::class, $classType)
                );
            }
        }
    }

    abstract protected function classType(): string;

    public function getIterator(): ArrayIterator
    {
        return new ArrayIterator($this->items());
    }

    public function count(): int
    {
        return count($this->items());
    }

    public function items(): array
    {
        return $this->items;
    }

}
