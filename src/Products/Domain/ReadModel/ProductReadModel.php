<?php

declare(strict_types=1);

namespace ECommerce\Products\Domain\ReadModel;

final readonly class ProductReadModel
{
    public function __construct(
        public string $sku,
        public string $type,
        public string $name,
        public bool $isPublished,
        public ?string $shortDescription,
        public string $description,
        public bool $inStock,
        public string $categories,
        public string $productImages,
        public int $price,
    ) {
    }
}
