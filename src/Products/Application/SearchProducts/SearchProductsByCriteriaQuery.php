<?php

declare(strict_types=1);

namespace ECommerce\Products\Application\SearchProducts;

use ECommerce\Shared\Domain\Criteria\Filters;
use ECommerce\Shared\Domain\Criteria\Order;

final readonly class SearchProductsByCriteriaQuery
{
    public Filters $filters;
    public Order $order;

    public function __construct(
        array $filters,
        ?string $orderBy,
        ?string $order,
        public ?int $limit,
        public ?int $offset
    ) {
        $this->filters = Filters::fromValues($filters);
        $this->order = Order::fromValues($orderBy, $order);
    }
}
