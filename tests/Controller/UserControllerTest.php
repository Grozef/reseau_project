<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class UserControllerTest extends WebTestCase
{
    public function testListUsers(): void
    {
        $client = static::createClient();
        $client->request('GET', '/users');

        $this->assertResponseIsSuccessful();
        $this->assertResponseHeaderSame('Content-Type', 'application/json');
        $this->assertJson($client->getResponse()->getContent());
    }

    public function testCreateUser(): void
    {
        $client = static::createClient();

        $client->request('POST', '/users', [], [], [
            'CONTENT_TYPE' => 'application/json',
        ], json_encode([
            'username' => 'JohnDoe',
            'email' => 'johndoe@example.com',
            'password' => 'securepassword',
        ]));

        $this->assertResponseStatusCodeSame(201);
        $this->assertJson($client->getResponse()->getContent());
        $this->assertStringContainsString('Utilisateur créé', $client->getResponse()->getContent());
    }

    public function testGetSingleUser(): void
    {
        $client = static::createClient();

        $client->request('GET', '/users/1');

        $this->assertResponseIsSuccessful();
        $this->assertResponseHeaderSame('Content-Type', 'application/json');
        $this->assertJson($client->getResponse()->getContent());
        $this->assertStringContainsString('"id":1', $client->getResponse()->getContent());
    }

    public function testUpdateUser(): void
    {
        $client = static::createClient();

        $client->request('PUT', '/users/1', [], [], [
            'CONTENT_TYPE' => 'application/json',
        ], json_encode([
            'username' => 'UpdatedName',
            'email' => 'updated@example.com',
        ]));

        $this->assertResponseStatusCodeSame(200);
        $this->assertJson($client->getResponse()->getContent());
        $this->assertStringContainsString('Utilisateur mis à jour', $client->getResponse()->getContent());
    }

    public function testDeleteUser(): void
    {
        $client = static::createClient();

        $client->request('DELETE', '/users/1');

        $this->assertResponseStatusCodeSame(204);
    }
}
