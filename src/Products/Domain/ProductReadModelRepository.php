<?php

declare(strict_types=1);

namespace ECommerce\Products\Domain;

use ECommerce\Products\Domain\ReadModel\ProductReadModelCollection;
use ECommerce\Shared\Domain\Criteria\Criteria;

interface ProductReadModelRepository
{
    public function byCriteria(Criteria $criteria): ProductReadModelCollection;
}
