<?php

declare(strict_types=1);

namespace ECommerce\Apps\Web\Controllers\Products;

use ECommerce\Products\Application\SearchProducts\SearchProductsByCriteriaQuery;
use ECommerce\Products\Application\SearchProducts\SearchProductsByCriteriaQueryHandler;
use ECommerce\Products\Domain\ReadModel\ProductReadModelCollection;
use ECommerce\Shared\Infrastructure\Http\Controllers\ApiController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class SearchProductsByCriteriaController extends ApiController
{
    public function __construct(
        private readonly SearchProductsByCriteriaQueryHandler $searchProductsByCriteria,
        private readonly SearchProductsByCriteriaHttpRequest $searchProductsHttpRequest,
    ) {
    }

    #[Route(path: '/products', methods: ['POST', 'OPTIONS'])]
    public function __invoke(Request $request): Response
    {
        return $this->handleGenericErrors(function () use ($request) {
            $this->searchProductsHttpRequest->validate($request);

            $query = new SearchProductsByCriteriaQuery(
                $this->searchProductsHttpRequest->filters(),
                $this->searchProductsHttpRequest->orderBy(),
                $this->searchProductsHttpRequest->order(),
                $this->searchProductsHttpRequest->limit(),
                $this->searchProductsHttpRequest->offset(),
            );

            $products = ($this->searchProductsByCriteria)($query);

            return $this->buildResponse($products);
        });
    }

    private function buildResponse(ProductReadModelCollection $products): JsonResponse
    {
        return new JsonResponse(
            [
                'hits' => $products->items(),
                'total' => $products->count(),
            ],
            Response::HTTP_OK
        );
    }
}
