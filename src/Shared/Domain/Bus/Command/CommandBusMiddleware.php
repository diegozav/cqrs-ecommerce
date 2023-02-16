<?php

declare(strict_types=1);

namespace ECommerce\Shared\Domain\Bus\Command;

interface CommandBusMiddleware
{
    public function handle(Command $command, callable $next): void;
}
