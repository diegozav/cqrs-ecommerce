<?php

declare(strict_types=1);

namespace ECommerce\Tests\Shared\Infrastructure\Behat;

use Behat\Gherkin\Node\PyStringNode;
use Behat\MinkExtension\Context\RawMinkContext;
use Doctrine\DBAL\Connection;
use ECommerce\Shared\Infrastructure\Http\JsonSchemaValidator;
use ECommerce\Tests\Shared\Infrastructure\Persistence\PostgresDatabaseCleaner;
use Exception;
use RuntimeException;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;

use function Lambdish\Phunctional\apply;

class ApiContext extends RawMinkContext
{
    public function __construct(
        protected Connection $connection,
        protected readonly KernelBrowser $httpClient,
        private readonly JsonSchemaValidator $jsonSchemaValidator,
    ) {
    }

    /**
     * @BeforeScenario
     */
    public function beforeScenario(): void
    {
        apply(new PostgresDatabaseCleaner(), [$this->connection]);
    }

    /**
     * @Given I send a :method request to :url
     */
    public function iSendARequestTo(string $method, string $url): void
    {
        $this->httpClient->jsonRequest($method, $this->locatePath($url));
    }

    /**
     * @When I send a :method request to :url with body:
     */
    public function iSendARequestToWithBody(string $method, string $url, PyStringNode $body)
    {
        $requestBody = json_decode($body->getRaw(), true);
        $this->httpClient->jsonRequest($method, $this->locatePath($url), $requestBody);
    }

    /**
     * @Then /^the response status code should be (?P<expectedResponseCode>\d+)$/
     */
    public function theResponseStatusCodeShouldBe(string $expectedResponseCode): void
    {
        $response = $this->httpClient->getResponse();

        if ($response->getStatusCode() !== (int) $expectedResponseCode) {
            $previousException = new Exception(sprintf('HTTP Request TRACE: [%s]', $response->getContent()));

            throw new RuntimeException(
                sprintf(
                    'The status code <%s> does not match the expected <%s>',
                    $response->getStatusCode(),
                    $expectedResponseCode
                ),
                0,
                $previousException
            );
        }
    }

    /**
     * @Then the response content should be:
     */
    public function theResponseContentShouldBe(PyStringNode $expectedResponse): void
    {
        $expected = $this->sanitizeOutput($expectedResponse->getRaw());
        $actual = $this->sanitizeOutput($this->httpClient->getResponse()->getContent());

        if ($expected !== $actual) {
            throw new RuntimeException(
                sprintf("The outputs does not match!\n\n-- Expected:\n%s\n\n-- Actual:\n%s", $expected, $actual)
            );
        }
    }

    /**
     * @Given /^the response content should have the following schema:$/
     */
    public function theResponseContentShouldHaveTheFollowingSchema(PyStringNode $expectedSchema)
    {
        $schema = $this->sanitizeOutput($expectedSchema->getRaw());
        $response = $this->sanitizeOutput($this->httpClient->getResponse()->getContent());

        $errors = $this->jsonSchemaValidator->validate(json_decode($response), $schema);

        if ($errors) {
            throw new RuntimeException(
                sprintf(
                    "The response schema is invalid:\n\n%s\n\n",
                    json_encode(json_decode($response), JSON_PRETTY_PRINT)
                )
            );
        }
    }

    private function sanitizeOutput(string $output): string
    {
        return json_encode(json_decode(trim($output), true));
    }
}
