<?php

declare(strict_types=1);

namespace ECommerce\Users\Domain\Exception;

use ECommerce\Shared\Domain\Exception\InvalidArgumentException;

use function sprintf;

final class UserPasswordNotValidException extends InvalidArgumentException
{
    public static function doesNotContainNumbers(): self
    {
        return new self('Password must contain at least one number');
    }

    public static function doesNotContainUppercaseLetters(): self
    {
        return new self('Password must contain at least one uppercase letter');
    }

    public static function doesNotContainLowercaseLetters(): self
    {
        return new self('Password must contain at least one lowercase letter');
    }

    public static function doesNotHaveAMinimumLength(int $minLength): self
    {
        return new self(sprintf('Password does not have at least %d characters length.', $minLength));
    }

    public static function exceedsMaximumLength(int $maxLength): self
    {
        return new self(sprintf('Password exceeds the maximum size allowed. Max. [%d] characters.', $maxLength));
    }
}
