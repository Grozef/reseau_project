<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class PostControllerTest extends WebTestCase
{
    public function testListPosts(): void
    {
        $client = static::createClient();
        $client->request('GET', '/posts');

        $this->assertResponseIsSuccessful();
        $this->assertResponseHeaderSame('Content-Type', 'application/json');
        $this->assertJson($client->getResponse()->getContent());
    }

    public function testCreatePost(): void
    {
        $client = static::createClient();

        $client->request('POST', '/posts', [], [], [
            'CONTENT_TYPE' => 'application/json',
        ], json_encode([
            'social_account_id' => 1,
            'content' => 'Test post content',
            'scheduled_at' => '2025-01-10T12:00:00',
        ]));

        $this->assertResponseStatusCodeSame(201);
        $this->assertJson($client->getResponse()->getContent());
        $this->assertStringContainsString('Publication créée', $client->getResponse()->getContent());
    }
}
