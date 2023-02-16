<?php

declare(strict_types=1);

namespace ECommerce\Shared\Domain\DateTimeGenerator;

interface DateTimeGenerator
{
    public function generate(): string;
}
