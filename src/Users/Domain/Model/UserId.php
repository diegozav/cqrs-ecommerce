<?php

declare(strict_types=1);

namespace ECommerce\Users\Domain\Model;

use ECommerce\Users\Domain\Exception\UserIdNotValidException;
use Ramsey\Uuid\Uuid;

final class UserId
{
    public function __construct(
        public string $value
    ) {
        $this->ensureIsValid($value);
    }

    private function ensureIsValid(string $value): void
    {
        if (! Uuid::isValid($value)) {
            throw UserIdNotValidException::default($value);
        }
    }
}
