<?php

declare(strict_types=1);

namespace ECommerce\Shared\Domain\Criteria;

use ECommerce\Shared\Domain\Collection;

use function Lambdish\Phunctional\reduce;
use function array_merge;
use function array_map;

final readonly class Filters extends Collection
{
    public static function fromValues(array $values): self
    {
        return new self(array_map(self::filterBuilder(), $values));
    }

    private static function filterBuilder(): callable
    {
        return fn(array $values) => Filter::fromValues($values);
    }

    public function add(Filter $filter): self
    {
        return new self(array_merge($this->items(), [$filter]));
    }

    public function filters(): array
    {
        return $this->items();
    }

    public function serialize(): string
    {
        return reduce(
            static fn(string $accumulate, Filter $filter) => sprintf('%s^%s', $accumulate, $filter->serialize()),
            $this->items(),
            ''
        );
    }

    protected function classType(): string
    {
        return Filter::class;
    }
}
