<?php

namespace App\Tests\Entity;

use App\Entity\Media;
use App\Entity\Message;
use App\Entity\Post;
use PHPUnit\Framework\TestCase;

class MediaTest extends TestCase
{
    public function testMediaSettersAndGetters(): void
    {
        $media = new Media();

        $media->setFilePath('test/path/to/file.jpg');
        $media->setType('image/jpeg');
        $media->setCreatedAt(new \DateTimeImmutable());

        $this->assertEquals('test/path/to/file.jpg', $media->getFilePath());
        $this->assertEquals('image/jpeg', $media->getType());
        $this->assertInstanceOf(\DateTimeImmutable::class, $media->getCreatedAt());
    }

    public function testMediaMessageRelations(): void
    {
        $media = new Media();

        // Utiliser une vraie instance de Message
        $message = new Message();
        $media->addRelation($message);

        $this->assertCount(1, $media->getRelation());
        $this->assertSame($message, $media->getRelation()->first());

        // Supprimer la relation
        $media->removeRelation($message);
        $this->assertCount(0, $media->getRelation());
    }

    public function testMediaPostRelations(): void
    {
        $media = new Media();

        // Utiliser une vraie instance de Post
        $post = new Post();
        $media->addPost($post);

        $this->assertCount(1, $media->getPosts());
        $this->assertSame($post, $media->getPosts()->first());

        // Supprimer la relation
        $media->removePost($post);
        $this->assertCount(0, $media->getPosts());
    }
}
