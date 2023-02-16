<?php

declare(strict_types=1);

namespace ECommerce\Shared\Infrastructure\Http;

use RuntimeException;

final class JsonSchemaValidationException extends RuntimeException
{
    public static function default(array $errors): self
    {
        return new self(json_encode($errors));
    }
}
