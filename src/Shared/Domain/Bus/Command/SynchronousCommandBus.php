<?php

declare(strict_types=1);

namespace ECommerce\Shared\Domain\Bus\Command;

use Closure;

final class SynchronousCommandBus implements CommandBus
{
    private Closure $middlewareChain;

    public function __construct(CommandBusMiddleware ...$middlewareChain)
    {
        $this->middlewareChain = $this->createExecutionChain(...$middlewareChain);
    }

    public function dispatch(Command $command): void
    {
        ($this->middlewareChain)($command);
    }

    private function createExecutionChain(CommandBusMiddleware ...$middlewareList): Closure
    {
        $lastCallable = static fn () => null;

        while ($middleware = array_pop($middlewareList)) {
            $lastCallable = static fn (Command $command) => $middleware->handle($command, $lastCallable);
        }

        return $lastCallable;
    }
}
