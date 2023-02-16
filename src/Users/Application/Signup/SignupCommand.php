<?php

declare(strict_types=1);

namespace ECommerce\Users\Application\Signup;

use ECommerce\Shared\Domain\Bus\Command\Command;
use ECommerce\Users\Domain\Model\UserEmail;
use ECommerce\Users\Domain\Model\UserId;
use ECommerce\Users\Domain\Model\UserName;
use ECommerce\Users\Domain\Model\UserPassword;

final readonly class SignupCommand implements Command
{
    public UserId $id;

    public UserName $name;

    public UserEmail $email;

    public UserPassword $password;

    public function __construct(string $id, string $name, string $email, string $password)
    {
        $this->id = new UserId($id);
        $this->name = new UserName($name);
        $this->email = new UserEmail($email);
        $this->password = new UserPassword($password);
    }
}
