<?php

declare(strict_types=1);

namespace ECommerce\Users\Application\Signup;

use ECommerce\Shared\Domain\Bus\EventBus;
use ECommerce\Shared\Domain\Exception\EventBusNotAvailableException;
use ECommerce\Shared\Domain\Exception\RepositoryNotAvailableException;
use ECommerce\Users\Domain\Exception\UserAlreadyExistsException;
use ECommerce\Users\Domain\Model\User;
use ECommerce\Users\Domain\UserRepository;

final readonly class SignupCommandHandler
{
    public function __construct(
        private UserRepository $repository,
        private EventBus $eventBus,
    )
    {
    }

    public function __invoke(SignupCommand $command): void
    {
        if (null !== $this->repository->findByEmail($command->email)) {
            throw UserAlreadyExistsException::fromEmail($command->email->value);
        }

        $user = User::create(
            $command->id,
            $command->name,
            $command->email,
            $command->password,
        );

        $this->repository->persist($user);

        $this->eventBus->publish(...$user->pullDomainEvents());
    }
}
