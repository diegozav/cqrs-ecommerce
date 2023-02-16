<?php

declare(strict_types=1);

namespace ECommerce\Users\Domain\Exception;

use ECommerce\Shared\Domain\Exception\InvalidArgumentException;

use function sprintf;

final class UserNameNotValidException extends InvalidArgumentException
{
    public static function cannotContainNumbersOrSymbols(): self
    {
        return new self('User name cannot contain numbers symbols');
    }

    public static function doesNotHaveAMinimumLength(int $length): self
    {
        return new self(sprintf('User name does not have at least %d characters length.', $length));
    }

    public static function exceedsMaximumLength(int $length): self
    {
        return new self(sprintf('User name exceeds the maximum size allowed. Max. %d characters.', $length));
    }
}
