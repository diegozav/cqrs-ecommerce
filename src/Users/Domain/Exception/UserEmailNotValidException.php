<?php

declare(strict_types=1);

namespace ECommerce\Users\Domain\Exception;

use ECommerce\Shared\Domain\Exception\InvalidArgumentException;

use function sprintf;

final class UserEmailNotValidException extends InvalidArgumentException
{
    public static function default(string $email): self
    {
        return new self(sprintf('User email %s not valid', $email));
    }
}
