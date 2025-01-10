<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class AuthControllerTest extends WebTestCase
{
    public function testLogin(): void
    {
        $client = static::createClient();

        $client->request('POST', '/auth/login', [], [], [
            'CONTENT_TYPE' => 'application/json',
        ], json_encode([
            'email' => 'johndoe@example.com',
            'password' => 'securepassword',
        ]));

        $this->assertResponseIsSuccessful();
        $this->assertResponseHeaderSame('Content-Type', 'application/json');
        $this->assertJson($client->getResponse()->getContent());
        $this->assertStringContainsString('token', $client->getResponse()->getContent());
    }

    public function testLoginInvalidCredentials(): void
    {
        $client = static::createClient();

        $client->request('POST', '/auth/login', [], [], [
            'CONTENT_TYPE' => 'application/json',
        ], json_encode([
            'email' => 'wrong@example.com',
            'password' => 'wrongpassword',
        ]));

        $this->assertResponseStatusCodeSame(401);
        $this->assertJson($client->getResponse()->getContent());
        $this->assertStringContainsString('Invalid credentials', $client->getResponse()->getContent());
    }

    public function testLogout(): void
    {
        $client = static::createClient();

        // Simuler un utilisateur authentifié avec un token
        $client->request('POST', '/auth/logout', [], [], [
            'HTTP_Authorization' => 'Bearer valid-token',
        ]);

        $this->assertResponseStatusCodeSame(200);
        $this->assertJson($client->getResponse()->getContent());
        $this->assertStringContainsString('Logged out successfully', $client->getResponse()->getContent());
    }

    public function testTokenValidation(): void
    {
        $client = static::createClient();

        $client->request('GET', '/auth/validate-token', [], [], [
            'HTTP_Authorization' => 'Bearer valid-token',
        ]);

        $this->assertResponseIsSuccessful();
        $this->assertResponseHeaderSame('Content-Type', 'application/json');
        $this->assertJson($client->getResponse()->getContent());
        $this->assertStringContainsString('"valid":true', $client->getResponse()->getContent());
    }

    public function testTokenValidationInvalidToken(): void
    {
        $client = static::createClient();

        $client->request('GET', '/auth/validate-token', [], [], [
            'HTTP_Authorization' => 'Bearer invalid-token',
        ]);

        $this->assertResponseStatusCodeSame(401);
        $this->assertJson($client->getResponse()->getContent());
        $this->assertStringContainsString('Invalid token', $client->getResponse()->getContent());
    }
}
