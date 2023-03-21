<?php

declare(strict_types=1);

namespace ECommerce\Apps\Web\Controllers\SearchProducts;

use ECommerce\Products\Application\SearchProducts\SearchProductsByCriteriaQuery;
use ECommerce\Products\Application\SearchProducts\SearchProductsByCriteriaQueryHandler;
use ECommerce\Shared\Infrastructure\Http\Controllers\ApiController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class SearchProductsByCriteriaController extends ApiController
{
    public function __construct(private SearchProductsByCriteriaQueryHandler $searchProductsByCriteriaQueryHandler)
    {
    }

    #[Route(path: '/products', methods: ['POST', 'OPTIONS'])]
    public function __invoke(Request $request): Response
    {
        $query = new SearchProductsByCriteriaQuery(
            [],
            null,
            null,
            10,
            0
        );

        $products = ($this->searchProductsByCriteriaQueryHandler)($query);

        return new JsonResponse($products->items(), Response::HTTP_OK);
    }
}
