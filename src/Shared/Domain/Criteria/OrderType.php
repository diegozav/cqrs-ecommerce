<?php

declare(strict_types=1);

namespace ECommerce\Shared\Domain\Criteria;

use ECommerce\Shared\Domain\Exception\InvalidArgumentException;

enum OrderType: string
{
    case ASC = 'asc';
    case DESC = 'desc';
    case NONE = 'none';

    public function isNone(): bool
    {
        return $this->value == self::NONE;
    }

    public static function fromValue(string $value): self
    {
        if (!self::tryFrom($value)) {
            throw new InvalidArgumentException(sprintf('Invalid value %s for %s', $value, self::class));
        }

        return self::from($value);
    }
}
