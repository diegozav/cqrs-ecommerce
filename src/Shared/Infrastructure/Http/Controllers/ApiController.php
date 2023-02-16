<?php

declare(strict_types=1);

namespace ECommerce\Shared\Infrastructure\Http\Controllers;

use ECommerce\Shared\Domain\Exception\EventBusNotAvailableException;
use ECommerce\Shared\Domain\Exception\EventStoreNotAvailableException;
use ECommerce\Shared\Domain\Exception\InvalidArgumentException;
use ECommerce\Shared\Domain\Exception\NotFoundException;
use ECommerce\Shared\Domain\Exception\RepositoryNotAvailableException;
use ECommerce\Shared\Infrastructure\Http\JsonSchemaValidationException;
use Exception;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class ApiController
{
    public function handleGenericErrors(callable $fn): JsonResponse
    {
        try {
            return $fn();
        } catch (Exception $exception) {
            if ($exception instanceof JsonSchemaValidationException) {
                return new JsonResponse(json_decode($exception->getMessage()), Response::HTTP_BAD_REQUEST);
            }

            if ($exception instanceof InvalidArgumentException) {
                return new JsonResponse([
                    'message' => $exception->getMessage(),
                ], Response::HTTP_BAD_REQUEST);
            }

            if ($exception instanceof NotFoundException) {
                return new JsonResponse([
                    'message' => $exception->getMessage(),
                ], Response::HTTP_NOT_FOUND);
            }

            if ($exception instanceof RepositoryNotAvailableException) {
                return new JsonResponse([
                    'message' => 'Service not available',
                ], Response::HTTP_SERVICE_UNAVAILABLE);
            }

            if ($exception instanceof EventStoreNotAvailableException) {
                return new JsonResponse([
                    'message' => 'Service not available',
                ], Response::HTTP_SERVICE_UNAVAILABLE);
            }

            if ($exception instanceof EventBusNotAvailableException) {
                return new JsonResponse([
                    'message' => 'Service not available',
                ], Response::HTTP_SERVICE_UNAVAILABLE);
            }

            throw $exception;
        }
    }
}
