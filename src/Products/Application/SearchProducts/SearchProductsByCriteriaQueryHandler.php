<?php

declare(strict_types=1);

namespace ECommerce\Products\Application\SearchProducts;

use ECommerce\Products\Domain\ProductReadModelRepository;
use ECommerce\Products\Domain\ReadModel\ProductReadModelCollection;
use ECommerce\Shared\Domain\Criteria\Criteria;

final readonly class SearchProductsByCriteriaQueryHandler
{
    public function __construct(private ProductReadModelRepository $repository)
    {
    }

    public function __invoke(SearchProductsByCriteriaQuery $query): ProductReadModelCollection
    {
        $criteria = new Criteria($query->filters, $query->order, $query->offset, $query->limit);

        return $this->repository->byCriteria($criteria);
    }
}
