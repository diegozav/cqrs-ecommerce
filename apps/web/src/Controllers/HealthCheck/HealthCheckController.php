<?php

declare(strict_types=1);

namespace ECommerce\Apps\Web\Controllers\HealthCheck;

use ECommerce\Shared\Domain\DateTimeGenerator\DateTimeGenerator;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class HealthCheckController
{
    public function __construct(
        private readonly DateTimeGenerator $dateTimeGenerator
    ) {
    }

    #[Route('/health-check', name: 'health_check', methods: ['GET'])]
    public function __invoke(): JsonResponse
    {
        return new JsonResponse(
            [
                'status' => 'healthy',
                'date' => $this->dateTimeGenerator->generate(),
            ],
            Response::HTTP_OK
        );
    }
}
