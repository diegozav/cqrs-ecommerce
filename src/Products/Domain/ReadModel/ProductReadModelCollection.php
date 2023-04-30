<?php

declare(strict_types=1);

namespace ECommerce\Products\Domain\ReadModel;

use ECommerce\Shared\Domain\Collection;

final readonly class ProductReadModelCollection extends Collection
{
    protected function classType(): string
    {
        return ProductReadModel::class;
    }
}
