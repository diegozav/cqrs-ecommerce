<?php

namespace ECommerce\Users\Domain;

use ECommerce\Shared\Domain\Exception\RepositoryNotAvailableException;
use ECommerce\Users\Domain\Model\User;
use ECommerce\Users\Domain\Model\UserEmail;
use ECommerce\Users\Domain\Model\UserId;

interface UserRepository
{
    /**
     * @param UserEmail $email
     * @return User|null
     * @throws RepositoryNotAvailableException
     */
    function findByEmail(UserEmail $email): User | null;

    /**
     * @param User $user
     * @return void
     * @throws RepositoryNotAvailableException
     */
    function persist(User $user): void;

    /**
     * @return UserId
     * @throws RepositoryNotAvailableException
     */
    function nextIdentity(): UserId;
}
