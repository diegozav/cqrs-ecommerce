<?php

declare(strict_types=1);

namespace ECommerce\Tests\Users\Infrastructure\Behat;

use Behat\Gherkin\Node\TableNode;
use ECommerce\Tests\Shared\Infrastructure\Behat\ApiContext;

use function Lambdish\Phunctional\each;

final class UsersFeatureContext extends ApiContext
{
    /**
     * @Given /^there are users with the following details:$/
     */
    public function thereAreUsersWithTheFollowingDetails(TableNode $table)
    {
        each(fn (array $row) => $this->connection->insert('users', $row), $table);
    }
}
