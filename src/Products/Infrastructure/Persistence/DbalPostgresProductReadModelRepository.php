<?php

declare(strict_types=1);

namespace ECommerce\Products\Infrastructure\Persistence;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Exception as DoctrineException;
use Doctrine\DBAL\Query\QueryBuilder;
use ECommerce\Products\Domain\ProductReadModelRepository;
use ECommerce\Products\Domain\ReadModel\ProductReadModel;
use ECommerce\Products\Domain\ReadModel\ProductReadModelCollection;
use ECommerce\Shared\Domain\Criteria\Criteria;
use ECommerce\Shared\Domain\Criteria\Filter;
use ECommerce\Shared\Domain\Criteria\FilterOperator;
use ECommerce\Shared\Domain\Exception\RepositoryNotAvailableException;

use function Lambdish\Phunctional\each;
use function Lambdish\Phunctional\map;

final readonly class DbalPostgresProductReadModelRepository implements ProductReadModelRepository
{
    private const TABLE_NAME = 'products';

    public function __construct(
        private Connection $connection
    ) {
    }

    public function byCriteria(Criteria $criteria): ProductReadModelCollection
    {
        try {
            $queryBuilder = $this->connection->createQueryBuilder();

            $queryBuilder
                ->select('*')
                ->from(self::TABLE_NAME);

            if ($criteria->hasFilters()) {
                each($this->applyFilter($queryBuilder), $criteria->filters);
            }

            if ($criteria->hasOrder()) {
                $queryBuilder->orderBy($criteria->order->orderBy->value, $criteria->order->orderType->value);
            }

            $queryBuilder->setMaxResults($criteria->limit);
            $queryBuilder->setFirstResult($criteria->offset);

            $rows = $queryBuilder->fetchAllAssociative();

            return new ProductReadModelCollection(map($this->transformToProduct(), $rows));
        } catch (DoctrineException) {
            throw RepositoryNotAvailableException::default();
        }
    }

    private function applyFilter(QueryBuilder $queryBuilder): callable
    {
        return static function (Filter $filter) use ($queryBuilder) {
            if ($filter->operator->equals(FilterOperator::CONTAINS)) {
                $bindingKey = "f_contains_{$filter->field->value}";

                $queryBuilder
                    ->where($queryBuilder->expr()->like($filter->field->value, ":{$bindingKey}"))
                    ->setParameter($bindingKey, "%{$filter->value->value}%");
            }

            if ($filter->operator->equals(FilterOperator::EQUAL)) {
                $queryBuilder
                    ->where($filter->field->value, $filter->value->value);
            }
        };
    }

    private function transformToProduct(): callable
    {
        return fn (array $row) => new ProductReadModel(
            $row['sku'],
            $row['type'],
            $row['name'],
            $row['is_published'],
            $row['short_description'],
            $row['description'],
            $row['in_stock'],
            $row['categories'],
            $row['images'],
            $row['price'],
        );
    }
}
