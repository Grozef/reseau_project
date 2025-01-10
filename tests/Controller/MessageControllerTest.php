<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class MessageControllerTest extends WebTestCase
{
    public function testListMessages(): void
    {
        $client = static::createClient();
        $client->request('GET', '/messages');

        $this->assertResponseIsSuccessful();
        $this->assertResponseHeaderSame('Content-Type', 'application/json');
        $this->assertJson($client->getResponse()->getContent());
    }

    public function testCreateMessage(): void
    {
        $client = static::createClient();

        $client->request('POST', '/messages', [], [], [
            'CONTENT_TYPE' => 'application/json',
        ], json_encode([
            'relation_id' => 1,
            'content' => 'This is a test message',
            'sender' => ['name' => 'John Doe'],
            'recipient' => ['name' => 'Jane Doe'],
        ]));

        $this->assertResponseStatusCodeSame(201);
        $this->assertJson($client->getResponse()->getContent());
        $this->assertStringContainsString('Message créé', $client->getResponse()->getContent());
    }
}
