<?php

declare(strict_types=1);

namespace ECommerce\Shared\Infrastructure\Bus\Command;

use ECommerce\Shared\Domain\Bus\Command\Command;
use RuntimeException;

final class CommandToHandlerMapping
{
    public function findHandlerForCommand(Command $command): string
    {
        $suffix = 'Handler';

        $handlerClass = $command::class . $suffix;

        if (! class_exists($handlerClass)) {
            throw new RuntimeException(sprintf('Command handler [%s] not found', $handlerClass));
        }

        return $handlerClass;
    }
}
