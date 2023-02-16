<?php

declare(strict_types=1);

namespace ECommerce\Users\Domain\Model;

use ECommerce\Users\Domain\Exception\UserEmailNotValidException;

final readonly class UserEmail
{
    public function __construct(
        public string $value
    ) {
        $this->ensureIsValid($value);
    }

    private function ensureIsValid(string $value): void
    {
        if (! preg_match("/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix", $value)) {
            throw UserEmailNotValidException::default($value);
        }
    }
}
