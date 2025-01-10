<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class MediaControllerTest extends WebTestCase
{
    public function testUploadMedia(): void
    {
        $client = static::createClient();

        // Simuler un fichier à uploader
        $file = tempnam(sys_get_temp_dir(), 'test');
        file_put_contents($file, 'dummy content');

        $client->request('POST', '/media/upload', [], [
            'file' => new \Symfony\Component\HttpFoundation\File\UploadedFile(
                $file,
                'test.jpg',
                'image/jpeg',
                null,
                true
            )
        ]);

        $this->assertResponseStatusCodeSame(201);
        $this->assertJson($client->getResponse()->getContent());
        $this->assertStringContainsString('File uploaded successfully', $client->getResponse()->getContent());
    }
}
