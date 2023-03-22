<?php

declare(strict_types=1);

namespace ECommerce\Apps\Web\Controllers\Users;

use ECommerce\Shared\Infrastructure\Http\HttpRequestWithValidation;

final class SignupHttpRequest extends HttpRequestWithValidation
{
    protected string $name;

    protected string $email;

    protected string $password;

    public function name(): string
    {
        return $this->name;
    }

    public function email(): string
    {
        return $this->email;
    }

    public function password(): string
    {
        return $this->password;
    }

    protected static function schema(): string
    {
        return <<<'JSON'
            {
                "$schema": "https://json-schema.org/draft/2020-12/schema",
                "$id": "http://cqrs-ecommerce.com/users/signup.json",
                "type": "object",
                "properties": {
                    "name": {
                        "type": "string",
                        "minLength": 3,
                        "maxLength": 30
                    },
                    "email": {
                        "type": "string",
                        "format": "email"
                    },
                    "password": {
                        "type": "string",
                        "minLength": 8,
                        "maxLength": 32
                    }
                },
                "required": ["name", "email", "password"],
                "additionalProperties": false
            }
        JSON;
    }
}
