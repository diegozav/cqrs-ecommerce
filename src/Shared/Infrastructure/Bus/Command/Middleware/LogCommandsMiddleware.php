<?php

declare(strict_types=1);

namespace ECommerce\Shared\Infrastructure\Bus\Command\Middleware;

use DateTimeImmutable;
use ECommerce\Shared\Domain\Bus\Command\Command;
use ECommerce\Shared\Domain\Bus\Command\CommandBusMiddleware;
use Psr\Log\LoggerInterface;
use Psr\Log\LogLevel;

final readonly class LogCommandsMiddleware implements CommandBusMiddleware
{
    public function __construct(
        private LoggerInterface $logger
    ) {
    }

    public function handle(Command $command, callable $next): void
    {
        $body = json_encode([
            'type' => $command::class,
            'timestamp' => (new DateTimeImmutable())->format(DATE_ATOM),
            'data' => $command,
        ]);

        $this->logger->log(LogLevel::DEBUG, $body);

        $next($command);
    }
}
