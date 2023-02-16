<?php

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DriverManager;
use ECommerce\Shared\Domain\DateTimeGenerator\DateTimeGenerator;
use ECommerce\Shared\Infrastructure\PhpImmutableDateTimeGenerator;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

use function Symfony\Component\DependencyInjection\Loader\Configurator\tagged_iterator;

return function (ContainerConfigurator $container) {
    $baseDir = __DIR__ . '/../../..';

    $services = $container->services()
        ->defaults()
        ->autowire()
        ->autoconfigure()
    ;

    // Controllers
    $services->load(
        'ECommerce\\Apps\\Web\\Controllers\\',
        "$baseDir/apps/web/src/Controllers/"
    )
        ->tag('controller.service_arguments');


    // Autowire
    $services->load('ECommerce\\', "$baseDir/src/")
        ->exclude([
            "$baseDir/src/Users/Application/**/*Command.php",
            "$baseDir/src/{Shared,Users}/Domain/Model",
            "$baseDir/src/{Shared,Users}/Domain/Exception",
            "$baseDir/src/{Shared,Users}/Domain/Event",
        ])
        ->autoconfigure()
        ->autowire()
        ->public();

    // Doctrine Connection Setup
    $services->set(Connection::class, Connection::class)
        ->factory([DriverManager::class, 'getConnection'])
        ->arg('$params', ['url' => '%env(resolve:DATABASE_URL)%'])
        ->public();

    $services->set(DateTimeGenerator::class, PhpImmutableDateTimeGenerator::class);

    // Domain Events Configuration
    $services->instanceof('ECommerce\\Shared\\Domain\\Event\\DomainEvent')
        ->tag('ecommerce.domain_events');

    $services->set('ECommerce\\Shared\\Infrastructure\\Bus\\Event\\DomainEventLocator')
        ->args([tagged_iterator('ecommerce.domain_events')]);
};
