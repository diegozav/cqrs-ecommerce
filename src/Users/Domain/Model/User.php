<?php

declare(strict_types=1);

namespace ECommerce\Users\Domain\Model;

use ECommerce\Shared\Domain\Model\AggregateRoot;
use ECommerce\Users\Domain\Event\UserCreated;

final class User extends AggregateRoot
{
    public function __construct(
        private readonly UserId $id,
        private readonly UserName $name,
        private readonly UserEmail $email,
        private readonly UserPassword $password,
    ) {
    }

    public static function create(UserId $id, UserName $name, UserEmail $email, UserPassword $password): self
    {
        $user = new self($id, $name, $email, $password);

        $user->recordThat(UserCreated::occur($id->value, $name->value, $email->value));

        return $user;
    }

    public function id(): UserId
    {
        return $this->id;
    }

    public function name(): UserName
    {
        return $this->name;
    }

    public function email(): UserEmail
    {
        return $this->email;
    }

    public function password(): UserPassword
    {
        return $this->password;
    }
}
