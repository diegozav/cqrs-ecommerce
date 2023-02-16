<?php

declare(strict_types=1);

namespace ECommerce\Users\Domain\Exception;

use ECommerce\Shared\Domain\Exception\InvalidArgumentException;

use function sprintf;

final class UserIdNotValidException extends InvalidArgumentException
{
    public static function default(string $id): self
    {
        return new self(sprintf('User id %s not valid', $id));
    }
}
