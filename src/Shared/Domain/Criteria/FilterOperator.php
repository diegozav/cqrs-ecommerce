<?php

declare(strict_types=1);

namespace ECommerce\Shared\Domain\Criteria;

use ECommerce\Shared\Domain\Exception\InvalidArgumentException;

enum FilterOperator: string
{
    case EQUAL = '=';
    case NOT_EQUAL = '!=';
    case GT = '>';
    case LT = '<';
    case CONTAINS = 'CONTAINS';
    case NOT_CONTAINS = 'NOT_CONTAINS';

    public static function fromValue(string $value): self
    {
        if (! self::tryFrom($value)) {
            throw new InvalidArgumentException(sprintf('Invalid value %s for %s', $value, self::class));
        }

        return self::from($value);
    }

    public function equals(self $operator): bool
    {
        return $operator->value === $this->value;
    }
}
