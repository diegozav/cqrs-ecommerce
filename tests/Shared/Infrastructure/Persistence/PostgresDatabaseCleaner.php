<?php

declare(strict_types=1);

namespace ECommerce\Tests\Shared\Infrastructure\Persistence;

use Doctrine\DBAL\Connection;

use function Lambdish\Phunctional\map;
use function sprintf;

final class PostgresDatabaseCleaner
{
    public function __invoke(Connection $connection): void
    {
        $tables = $this->getTables($connection);

        $truncateTablesSql = $this->truncateDatabaseSql($tables);

        $connection->executeStatement($truncateTablesSql);
    }

    private function getTables(Connection $connection): array
    {
        $query = <<<SQL
            SELECT schemaname, tablename
            FROM pg_catalog.pg_tables
            WHERE schemaname LIKE 'public';
        SQL;

        return $connection->executeQuery($query)
            ->fetchAllAssociative();
    }

    private function truncateDatabaseSql(array $tables): string
    {
        $truncateQuery = <<<SQL
            --- Truncate table %s ---
            ALTER TABLE %s DISABLE TRIGGER ALL;
            TRUNCATE TABLE %s;
            ALTER TABLE %s ENABLE TRIGGER ALL;\n\n
        SQL;

        return implode(
            map(
                fn (array $table): string => sprintf(
                    $truncateQuery,
                    $table['tablename'],
                    $table['tablename'],
                    $table['tablename'],
                    $table['tablename']
                ),
                $tables
            )
        );
    }
}
