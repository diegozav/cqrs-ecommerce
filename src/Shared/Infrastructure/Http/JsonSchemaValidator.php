<?php

declare(strict_types=1);

namespace ECommerce\Shared\Infrastructure\Http;

use Opis\JsonSchema\Errors\ErrorFormatter;
use Opis\JsonSchema\Errors\ValidationError;
use Opis\JsonSchema\Validator;

final class JsonSchemaValidator
{
    private const MAX_SHOW_ERRORS = 5;

    private Validator $validator;

    public function __construct()
    {
        $this->validator = new Validator(max_errors: self::MAX_SHOW_ERRORS);
    }

    public function validate(object $data, string $schema): null | array
    {
        $result = $this->validator->validate($data, $schema);

        if (! $result->isValid()) {
            return $this->formatErrors($result->error());
        }

        return null;
    }

    private function formatErrors(ValidationError $error): array
    {
        $formatOutput = (new ErrorFormatter())->formatOutput($error, 'basic');

        $filteredErrors = array_values(
            array_filter($formatOutput['errors'], fn (array $error) => strlen($error['instanceLocation']) > 1)
        );

        $mappedErrors = array_map(
            fn (array $error) => [
                'field' => $error['instanceLocation'],
                'error' => $error['error'],
            ],
            $filteredErrors
        );

        return [
            'valid' => false,
            'errors' => $mappedErrors,
        ];
    }
}
