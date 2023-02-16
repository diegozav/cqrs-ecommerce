<?php

declare(strict_types=1);

namespace ECommerce\Users\Domain\Model;

use ECommerce\Users\Domain\Exception\UserPasswordNotValidException;

use function preg_match;
use function strlen;

final readonly class UserPassword
{
    private const MIN_LENGTH = 8;

    private const MAX_LENGTH = 32;

    public function __construct(
        public string $value
    ) {
        $this->ensureIsValid($value);
    }

    private function ensureIsValid(string $value): void
    {
        if (strlen($value) < self::MIN_LENGTH) {
            throw UserPasswordNotValidException::doesNotHaveAMinimumLength(self::MIN_LENGTH);
        }

        if (strlen($value) > self::MAX_LENGTH) {
            throw UserPasswordNotValidException::exceedsMaximumLength(self::MAX_LENGTH);
        }

        if (! preg_match('@[0-9]@', $value)) {
            throw UserPasswordNotValidException::doesNotContainNumbers();
        }

        if (! preg_match('@[A-Z]@', $value)) {
            throw UserPasswordNotValidException::doesNotContainUppercaseLetters();
        }

        if (! preg_match('@[a-z]@', $value)) {
            throw UserPasswordNotValidException::doesNotContainLowercaseLetters();
        }
    }
}
