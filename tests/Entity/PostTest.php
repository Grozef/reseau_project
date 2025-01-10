<?php

namespace App\Tests\Entity;

use App\Entity\Post;
use App\Entity\SocialAccount;
use PHPUnit\Framework\TestCase;

class PostTest extends TestCase
{
    public function testPostSettersAndGetters(): void
    {
        $post = new Post();

        $post->setContent('This is a test post');
        $post->setStatus('draft');
        $post->setScheduledAt(new \DateTimeImmutable('2025-01-10T12:00:00'));
        $post->setCreatedAt(new \DateTimeImmutable());

        $this->assertEquals('This is a test post', $post->getContent());
        $this->assertEquals('draft', $post->getStatus());
        $this->assertEquals(new \DateTimeImmutable('2025-01-10T12:00:00'), $post->getScheduledAt());
        $this->assertInstanceOf(\DateTimeImmutable::class, $post->getCreatedAt());
    }

    public function testPostSocialAccountRelation(): void
    {
        $post = new Post();

        // Utiliser une vraie instance de SocialAccount
        $socialAccount = new SocialAccount();
        $post->setRelation($socialAccount);

        $this->assertSame($socialAccount, $post->getRelation());
    }
}
