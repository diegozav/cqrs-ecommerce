<?php

declare(strict_types=1);

namespace ECommerce\Tests\Shared\Infrastructure;

use ECommerce\Shared\Domain\DateTimeGenerator\DateTimeGenerator;

final class StaticDateTimeGenerator implements DateTimeGenerator
{
    public function generate(): string
    {
        return '2023-02-27 12:32:00';
    }
}
