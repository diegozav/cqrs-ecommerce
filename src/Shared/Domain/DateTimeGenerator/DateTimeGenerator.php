<?php

declare(strict_types=1);

namespace ECommerce\Shared\Domain\DateTimeGenerator;

interface DateTimeGenerator
{
    function generate(): string;
}
