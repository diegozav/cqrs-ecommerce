<?php

declare(strict_types=1);

use ECommerce\Shared\Domain\DateTimeGenerator\DateTimeGenerator;
use ECommerce\Tests\Shared\Infrastructure\StaticDateTimeGenerator;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return function (ContainerConfigurator $container) {
    $baseDir = __DIR__ . '/../../..';

    $services = $container->services()
        ->defaults()
        ->autowire()
        ->autoconfigure()
    ;

    // Autowire
    $services->load('ECommerce\\Tests\\', "{$baseDir}/tests/")
        ->exclude([
            //"$baseDir/src/Users/Application/**/*Command.php",
            //"$baseDir/src/{Shared,Users}/Domain/Model",
            //"$baseDir/src/{Shared,Users}/Domain/Exception",
            //"$baseDir/src/{Shared,Users}/Domain/Event",
        ])
        ->autoconfigure()
        ->autowire()
        ->public();

    $services->set(DateTimeGenerator::class, StaticDateTimeGenerator::class);
};
