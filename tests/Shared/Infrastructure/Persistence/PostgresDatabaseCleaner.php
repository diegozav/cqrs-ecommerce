<?php

declare(strict_types=1);

namespace ECommerce\Tests\Shared\Infrastructure\Persistence;

use Doctrine\DBAL\Connection;

use function Lambdish\Phunctional\map;
use function sprintf;

final class PostgresDatabaseCleaner
{
    private array $excludedTables = [
        //'products'
    ];

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

        $rows = $connection->executeQuery($query)
            ->fetchAllAssociative();

        $tables = map(fn (array $row) => $row['tablename'], $rows);

        return array_diff($tables, $this->excludedTables);
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
            map(fn (string $table): string => sprintf($truncateQuery, $table, $table, $table, $table), $tables)
        );
    }
}
