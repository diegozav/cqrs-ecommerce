<?php

declare(strict_types=1);

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DriverManager;
use ECommerce\Shared\Domain\Bus\Command\SynchronousCommandBus;
use ECommerce\Shared\Domain\DateTimeGenerator\DateTimeGenerator;
use ECommerce\Shared\Infrastructure\Bus\Command\CommandToHandlerMapping;
use ECommerce\Shared\Infrastructure\Bus\Command\Middleware\HandleCommandsMiddleware;
use ECommerce\Shared\Infrastructure\Bus\Command\Middleware\LogCommandsMiddleware;
use ECommerce\Shared\Infrastructure\Bus\Command\Middleware\TransactionalCommandHandlerMiddleware;
use ECommerce\Shared\Infrastructure\PhpImmutableDateTimeGenerator;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

use function Symfony\Component\DependencyInjection\Loader\Configurator\service;
use function Symfony\Component\DependencyInjection\Loader\Configurator\tagged_iterator;

return function (ContainerConfigurator $container) {
    $baseDir = __DIR__ . '/../../..';

    $services = $container->services()
        ->defaults()
        ->autowire()
        ->autoconfigure();

    // Controllers
    $services->load('ECommerce\\Apps\\Web\\Controllers\\', "{$baseDir}/apps/web/src/Controllers/")
        ->tag('controller.service_arguments');

    // Autowire
    $services->load('ECommerce\\', "{$baseDir}/src/")
        ->exclude([
            "{$baseDir}/src/{Users,Products}/Application/**/*Command.php",
            "{$baseDir}/src/{Users,Products}/Application/**/*Query.php",
            "{$baseDir}/src/{Users,Products}/Domain/Model",
            "{$baseDir}/src/{Users,Products}/Domain/Event",
            "{$baseDir}/src/{Users,Products}/Domain/ReadModel",
            "{$baseDir}/src/{Users,Products}/Domain/Exception",
            "{$baseDir}/src/{Shared}/Domain/{Model,Exception,Criteria,ValueObject}",
        ])
        ->autoconfigure()
        ->autowire()
        ->public();

    // Doctrine Connection Setup
    $services->set(Connection::class, Connection::class)
        ->factory([DriverManager::class, 'getConnection'])
        ->arg('$params', [
            'url' => '%env(resolve:DATABASE_URL)%',
        ])
        ->share(true)
        ->public();

    $services->set(DateTimeGenerator::class, PhpImmutableDateTimeGenerator::class);

    $services->set(HandleCommandsMiddleware::class, HandleCommandsMiddleware::class)
        ->args([service('service_container'), service(CommandToHandlerMapping::class)]);

    $services->set(SynchronousCommandBus::class, SynchronousCommandBus::class)
        ->args([
            service(TransactionalCommandHandlerMiddleware::class),
            service(LogCommandsMiddleware::class),
            service(HandleCommandsMiddleware::class),
        ]);

    // Domain Events Configuration
    $services->instanceof('ECommerce\\Shared\\Domain\\Event\\DomainEvent')
        ->tag('ecommerce.domain_events');

    $services->set('ECommerce\\Shared\\Infrastructure\\Bus\\Event\\DomainEventLocator')
        ->args([tagged_iterator('ecommerce.domain_events')]);
};
