<?php

declare(strict_types=1);

namespace ECommerce\Apps\Web\Controllers\Products;

use ECommerce\Shared\Infrastructure\Http\HttpRequestWithValidation;

final class SearchProductsByCriteriaHttpRequest extends HttpRequestWithValidation
{
    protected array $filters;

    protected ?string $orderBy;

    protected ?string $order;

    protected int $limit;

    protected int $offset;

    public function filters(): array
    {
        return $this->filters;
    }

    public function orderBy(): ?string
    {
        return $this->orderBy;
    }

    public function order(): ?string
    {
        return $this->order;
    }

    public function limit(): int
    {
        return $this->limit;
    }

    public function offset(): int
    {
        return $this->offset;
    }

    protected static function schema(): string
    {
        return <<<'JSON'
        {
            "$schema":"https://json-schema.org/draft/2020-12/schema",
            "$id":"http://cqrs-ecommerce.com/products/search-by-criteria.json",
            "type": "object",
            "properties":{
                "filters":{
                    "type":"array",
                    "minItems": 0,
                    "items" : {
                        "field" : "string",
                        "operator" : "string",
                        "value" : "string"
                    },
                    "required": ["field", "operator", "value"],
                    "additionalProperties": false
                },
                "orderBy":{
                    "type": ["string", "null"]
                },
                "order":{
                    "type": ["string", "null"]
                },
                "limit":{
                    "type": "number"
                },
                "offset":{
                    "type": "number"
                }
            },
            "required":[
                "filters",
                "orderBy",
                "order",
                "limit",
                "offset"
            ],
            "additionalProperties":false
        }
        JSON;
    }
}
