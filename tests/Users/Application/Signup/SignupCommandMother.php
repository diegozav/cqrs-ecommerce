<?php

declare(strict_types=1);

namespace ECommerce\Tests\Users\Application\Signup;

use ECommerce\Users\Application\Signup\SignupCommand;

final class SignupCommandMother
{
    public static function create(): SignupCommand
    {
        return new SignupCommand('f05939d3-7491-4776-9f67-37fb8db1c573', 'Jon', 'jdoe@mail.com', 'Aa123456*');
    }
}
