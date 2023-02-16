<?php

declare(strict_types=1);

namespace ECommerce\Users\Infrastructure\Persistence;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Exception;
use ECommerce\Shared\Domain\Exception\RepositoryNotAvailableException;
use ECommerce\Users\Domain\Model\User;
use ECommerce\Users\Domain\Model\UserEmail;
use ECommerce\Users\Domain\Model\UserId;
use ECommerce\Users\Domain\Model\UserName;
use ECommerce\Users\Domain\Model\UserPassword;
use ECommerce\Users\Domain\UserRepository;
use Ramsey\Uuid\Uuid;

final class DbalPostgresUserRepository implements UserRepository
{
    private const TABLE_NAME = 'users';

    public function __construct(
        private readonly Connection $connection
    ) {
    }

    public function findByEmail(UserEmail $email): User|null
    {
        $queryBuilder = $this->connection->createQueryBuilder();

        try {
            $result = $queryBuilder
                ->select('*')
                ->from(self::TABLE_NAME)
                ->where($queryBuilder->expr()->like('email', ':email'))
                ->setParameter('email', $email->value)
                ->fetchAssociative();
            if (! $result) {
                return null;
            }

            return new User(
                new UserId($result['id']),
                new UserName($result['name']),
                new UserEmail($result['email']),
                new UserPassword($result['password'])
            );
        } catch (Exception) {
            throw RepositoryNotAvailableException::default();
        }
    }

    public function persist(User $user): void
    {
        try {
            $this->connection->insert(self::TABLE_NAME, [
                'id' => $user->id()->value,
                'name' => $user->name()->value,
                'email' => $user->email()->value,
                'password' => $user->password()->value,
            ]);
        } catch (Exception) {
            throw RepositoryNotAvailableException::default();
        }
    }

    public function nextIdentity(): UserId
    {
        return new UserId(Uuid::uuid4()->toString());
    }
}
