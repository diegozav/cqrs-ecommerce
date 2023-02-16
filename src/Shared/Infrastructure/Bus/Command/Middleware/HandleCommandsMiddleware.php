<?php

declare(strict_types=1);

namespace ECommerce\Shared\Infrastructure\Bus\Command\Middleware;

use ECommerce\Shared\Domain\Bus\Command\Command;
use ECommerce\Shared\Domain\Bus\Command\CommandBusMiddleware;
use ECommerce\Shared\Infrastructure\Bus\Command\CommandToHandlerMapping;
use Psr\Container\ContainerInterface;

final readonly class HandleCommandsMiddleware implements CommandBusMiddleware
{
    public function __construct(
        private ContainerInterface $container,
        private CommandToHandlerMapping $mapping
    ) {
    }

    public function handle(Command $command, callable $next): void
    {
        $commandHandlerClass = $this->mapping->findHandlerForCommand($command);

        $commandHandler = $this->container->get($commandHandlerClass);

        ($commandHandler)($command);

        $next($command);
    }
}
