<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class SocialAccountControllerTest extends WebTestCase
{
    public function testListSocialAccounts(): void
    {
        $client = static::createClient();
        $client->request('GET', '/social-accounts');

        $this->assertResponseIsSuccessful();
        $this->assertResponseHeaderSame('Content-Type', 'application/json');
        $this->assertJson($client->getResponse()->getContent());
    }

    public function testCreateSocialAccount(): void
    {
        $client = static::createClient();

        $client->request('POST', '/social-accounts', [], [], [
            'CONTENT_TYPE' => 'application/json',
        ], json_encode([
            'user_id' => 1,
            'platform' => 'Facebook',
            'username' => 'TestUser',
        ]));

        $this->assertResponseStatusCodeSame(201);
        $this->assertJson($client->getResponse()->getContent());
        $this->assertStringContainsString('Compte social ajouté', $client->getResponse()->getContent());
    }
}
