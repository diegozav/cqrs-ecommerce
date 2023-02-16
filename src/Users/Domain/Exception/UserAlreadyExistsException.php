<?php

declare(strict_types=1);

namespace ECommerce\Users\Domain\Exception;

use ECommerce\Shared\Domain\Exception\InvalidArgumentException;

use function sprintf;

final class UserAlreadyExistsException extends InvalidArgumentException
{
    public static function fromEmail(string $email): self
    {
        return new self(sprintf('User with email %s already exists', $email));
    }
}
