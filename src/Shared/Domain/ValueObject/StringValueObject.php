<?php

declare(strict_types=1);

namespace ECommerce\Shared\Domain\ValueObject;

readonly class StringValueObject
{
    public function __construct(
        public string $value
    ) {
    }
}
