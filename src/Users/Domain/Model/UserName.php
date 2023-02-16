<?php

declare(strict_types=1);

namespace ECommerce\Users\Domain\Model;

use ECommerce\Users\Domain\Exception\UserNameNotValidException;

final readonly class UserName
{
    protected const MIN_LENGTH = 3;

    protected const MAX_LENGTH = 30;

    public function __construct(
        public string $value
    ) {
        $this->ensureIsValid($value);
    }

    private function ensureIsValid(string $value): void
    {
        if (! preg_match('/[a-zA-Z]$/', $value)) {
            throw UserNameNotValidException::cannotContainNumbersOrSymbols();
        }

        if (strlen($value) < self::MIN_LENGTH) {
            throw UserNameNotValidException::doesNotHaveAMinimumLength(self::MIN_LENGTH);
        }

        if (strlen($value) > self::MAX_LENGTH) {
            throw UserNameNotValidException::exceedsMaximumLength(self::MAX_LENGTH);
        }
    }
}
