<?php

declare(strict_types=1);

namespace ECommerce\Shared\Infrastructure;

use DateTimeImmutable;
use ECommerce\Shared\Domain\DateTimeGenerator\DateTimeGenerator;

final class PhpImmutableDateTimeGenerator implements DateTimeGenerator
{
    public function generate(): string
    {
        return (new DateTimeImmutable())->format('Y-m-d H:i:s');
    }
}
