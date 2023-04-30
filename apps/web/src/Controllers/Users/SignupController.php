<?php

declare(strict_types=1);

namespace ECommerce\Apps\Web\Controllers\Users;

use ECommerce\Shared\Domain\Bus\Command\CommandBus;
use ECommerce\Shared\Infrastructure\Http\Controllers\ApiController;
use ECommerce\Users\Application\Signup\SignupCommand;
use ECommerce\Users\Domain\UserRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class SignupController extends ApiController
{
    public function __construct(
        private readonly CommandBus $commandBus,
        private readonly UserRepository $userRepository,
        private readonly SignupHttpRequest $signupRequest,
    ) {
    }

    #[Route(path: '/users', methods: ['POST', 'OPTIONS'])]
    public function __invoke(Request $request): Response
    {
        return $this->handleGenericErrors(function () use ($request) {
            $this->signupRequest->validate($request);

            $userId = $this->userRepository->nextIdentity();

            $command = new SignupCommand(
                $userId->value,
                $this->signupRequest->name(),
                $this->signupRequest->email(),
                $this->signupRequest->password(),
            );

            $this->commandBus->dispatch($command);

            return new JsonResponse([
                'id' => $userId->value,
            ], Response::HTTP_CREATED);
        });
    }
}
