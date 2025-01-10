<?php

namespace App\Tests\Entity;

use App\Entity\Message;
use App\Entity\Media;
use App\Entity\SocialAccount;
use PHPUnit\Framework\TestCase;

class MessageTest extends TestCase
{
    public function testMessageSettersAndGetters(): void
    {
        $message = new Message();

        $message->setMessageId('MSG123');
        $message->setContent('This is a test message.');
        $message->setSender(['name' => 'John Doe']);
        $message->setRecipient(['name' => 'Jane Doe']);
        $message->setAttachments(['file1.jpg', 'file2.png']);
        $message->setStatus('sent');
        $message->setCreatedAt(new \DateTimeImmutable('2025-01-10T12:00:00'));

        $this->assertEquals('MSG123', $message->getMessageId());
        $this->assertEquals('This is a test message.', $message->getContent());
        $this->assertEquals(['name' => 'John Doe'], $message->getSender());
        $this->assertEquals(['name' => 'Jane Doe'], $message->getRecipient());
        $this->assertEquals(['file1.jpg', 'file2.png'], $message->getAttachments());
        $this->assertEquals('sent', $message->getStatus());
        $this->assertEquals(new \DateTimeImmutable('2025-01-10T12:00:00'), $message->getCreatedAt());
    }

    public function testMessageSocialAccountRelation(): void
    {
        $message = new Message();

        // Utiliser une vraie instance de SocialAccount
        $socialAccount = new SocialAccount();
        $message->setRelation($socialAccount);

        $this->assertSame($socialAccount, $message->getRelation());
    }

    public function testMessageMediaRelation(): void
    {
        $message = new Message();

        // Utiliser une vraie instance de Media
        $media = new Media();
        $message->setMedia($media);

        $this->assertSame($media, $message->getMedia());
    }
}
