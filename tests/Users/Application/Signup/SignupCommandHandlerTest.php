<?php

declare(strict_types=1);

namespace ECommerce\Tests\Users\Application\Signup;

use ECommerce\Shared\Domain\Bus\Event\EventBus;
use ECommerce\Users\Application\Signup\SignupCommandHandler;
use ECommerce\Users\Domain\Exception\UserAlreadyExistsException;
use ECommerce\Users\Domain\Model\User;
use ECommerce\Users\Domain\UserRepository;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

final class SignupCommandHandlerTest extends TestCase
{
    private SignupCommandHandler $signupCommandHandler;

    private UserRepository&MockObject $repository;

    private MockObject&EventBus $eventBus;

    protected function setUp(): void
    {
        $this->repository = $this->createMock(UserRepository::class);
        $this->eventBus = $this->createMock(EventBus::class);

        $this->signupCommandHandler = new SignupCommandHandler($this->repository, $this->eventBus);
    }

    public function testItShouldThrowAnExceptionWhenUserAlreadyExists(): void
    {
        // Given
        $command = SignupCommandMother::create();
        $user = new User($command->id, $command->name, $command->email, $command->password);

        // When
        $this->shouldFindUser($user);

        // Then
        $this->expectException(UserAlreadyExistsException::class);
        ($this->signupCommandHandler)($command);
    }

    public function testItShouldSignupANewUser(): void
    {
        // Given
        $command = SignupCommandMother::create();

        // When
        $this->shouldFindUser(null);
        $this->shouldSaveUser();
        $this->shouldPublishEvents();

        // Then
        ($this->signupCommandHandler)($command);
    }

    private function shouldFindUser(?User $user): void
    {
        $this->repository
            ->expects($this->once())
            ->method('findByEmail')
            ->willReturn($user);
    }

    private function shouldSaveUser(): void
    {
        $this->repository
            ->expects($this->once())
            ->method('persist');
    }

    private function shouldPublishEvents(): void
    {
        $this->eventBus
            ->expects($this->once())
            ->method('publish');
    }
}
