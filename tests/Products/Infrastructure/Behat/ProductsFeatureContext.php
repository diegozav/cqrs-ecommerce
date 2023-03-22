<?php

declare(strict_types=1);

namespace ECommerce\Tests\Products\Infrastructure\Behat;

use Behat\Gherkin\Node\TableNode;
use ECommerce\Tests\Shared\Infrastructure\Behat\ApiContext;
use RuntimeException;

use function Lambdish\Phunctional\each;

final class ProductsFeatureContext extends ApiContext
{
    /**
     * @Then /^the total number of products should be (\d+)$/
     */
    public function theTotalNumberOfProductsShouldBe(int $total): void
    {
        $response = json_decode($this->httpClient->getResponse()->getContent());

        if ($total !== $response->total) {
            throw new RuntimeException(
                sprintf(
                    "The expected number of items does not match!\n\n-- Expected:\n%d\n\n-- Actual:\n%d",
                    $total,
                    $count
                )
            );
        }
    }

    /**
     * @Given /^There are products with the following details:$/
     */
    public function thereAreProductsWithTheFollowingDetails(TableNode $table)
    {
        each(fn (array $row) => $this->connection->insert('products', $row), $table);
    }
}
