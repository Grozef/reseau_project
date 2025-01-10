<?php

namespace App\Tests\Entity;

use App\Entity\User;
use App\Entity\SocialAccount;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    public function testUserSettersAndGetters(): void
    {
        $user = new User();

        $user->setUserName('John Doe');
        $user->setEmail('john.doe@example.com');
        $user->setPassword('securepassword');

        $this->assertEquals('John Doe', $user->getUserName());
        $this->assertEquals('john.doe@example.com', $user->getEmail());
        $this->assertEquals('securepassword', $user->getPassword());
    }

    public function testUserSocialAccountsRelation(): void
    {
        $user = new User();

        // Utiliser une vraie instance de SocialAccount
        $socialAccount = new SocialAccount();
        $user->addSocialAccount($socialAccount);

        $this->assertCount(1, $user->getSocialAccounts());
        $this->assertSame($socialAccount, $user->getSocialAccounts()->first());

        // Tester la suppression de la relation
        $user->removeSocialAccount($socialAccount);
        $this->assertCount(0, $user->getSocialAccounts());
    }
}
