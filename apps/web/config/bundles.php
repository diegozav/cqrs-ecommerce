<?php

declare(strict_types=1);

use FriendsOfBehat\SymfonyExtension\Bundle\FriendsOfBehatSymfonyExtensionBundle;
use Symfony\Bundle\FrameworkBundle\FrameworkBundle;

return [
    FrameworkBundle::class => [
        'all' => true,
    ],
    FriendsOfBehatSymfonyExtensionBundle::class => [
        'test' => true,
    ],
];
