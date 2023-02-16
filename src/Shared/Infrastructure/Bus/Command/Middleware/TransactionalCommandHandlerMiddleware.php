<?php

declare(strict_types=1);

namespace ECommerce\Shared\Infrastructure\Bus\Command\Middleware;

use Doctrine\DBAL\Connection;
use ECommerce\Shared\Domain\Bus\Command\Command;
use ECommerce\Shared\Domain\Bus\Command\CommandBusMiddleware;

final readonly class TransactionalCommandHandlerMiddleware implements CommandBusMiddleware
{
    public function __construct(
        private Connection $connection
    ) {
    }

    public function handle(Command $command, callable $next): void
    {
        $transactionalOperation = fn () => $next($command);

        $this->connection->transactional($transactionalOperation);
    }
}
