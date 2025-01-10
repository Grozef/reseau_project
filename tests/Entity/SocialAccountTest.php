<?php

namespace App\Tests\Entity;

use App\Entity\SocialAccount;
use App\Entity\User;
use PHPUnit\Framework\TestCase;

class SocialAccountTest extends TestCase
{
    public function testSocialAccountSettersAndGetters(): void
    {
        $account = new SocialAccount();

        $account->setAccountName('TestAccount');
        $account->setPlatform('Facebook');

        $this->assertEquals('TestAccount', $account->getAccountName());
        $this->assertEquals('Facebook', $account->getPlatform());
    }

    public function testSocialAccountUserRelation(): void
    {
        $account = new SocialAccount();

        // Utiliser une vraie instance de User
        $user = new User();
        $account->setRelation($user);

        $this->assertSame($user, $account->getRelation());
    }
}
