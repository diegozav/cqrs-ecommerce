<?php

declare(strict_types=1);

namespace ECommerce\Shared\Infrastructure\Http;

use RuntimeException;
use Symfony\Component\HttpFoundation\Request;

abstract class HttpRequestWithValidation
{
    public function __construct(
        private readonly JsonSchemaValidator $validator
    ) {
    }

    /**
     * If schema is invalid, returns errors
     * Or return null if schema is valid
     */
    public function validate(Request $request): null | array
    {
        $this->ensureIsAValidJsonRequest($request);

        $requestBodyData = json_decode($request->getContent());

        $errors = $this->validator->validate($requestBodyData, static::schema());

        if ($errors) {
            throw JsonSchemaValidationException::default($errors);
        }

        foreach ($requestBodyData as $property => $value) {
            if (property_exists($this, $property)) {
                $this->{$property} = $value;
            }
        }

        return null;
    }

    abstract protected static function schema(): string;

    private function ensureIsAValidJsonRequest(Request $request): void
    {
        if (! $request->headers->contains('Content-Type', 'application/json')) {
            throw new RuntimeException('Invalid JSON Format on body request');
        }
    }
}
