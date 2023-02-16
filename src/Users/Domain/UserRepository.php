<?php

declare(strict_types=1);

namespace ECommerce\Users\Domain;

use ECommerce\Users\Domain\Model\User;
use ECommerce\Users\Domain\Model\UserEmail;
use ECommerce\Users\Domain\Model\UserId;

interface UserRepository
{
    public function findByEmail(UserEmail $email): User | null;

    public function persist(User $user): void;

    public function nextIdentity(): UserId;
}
