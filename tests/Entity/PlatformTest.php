<?php

namespace App\Tests\Entity;

use App\Entity\Platform;
use PHPUnit\Framework\TestCase;

class PlatformTest extends TestCase
{
    public function testPlatformSettersAndGetters(): void
    {
        $platform = new Platform();

        $platform->setName('Facebook');
        $platform->setApiUrl('https://api.facebook.com');
        $platform->setDescription('Social Media Platform');
        $platform->setCreatedAt(new \DateTimeImmutable());

        $this->assertEquals('Facebook', $platform->getName());
        $this->assertEquals('https://api.facebook.com', $platform->getApiUrl());
        $this->assertEquals('Social Media Platform', $platform->getDescription());
        $this->assertInstanceOf(\DateTimeImmutable::class, $platform->getCreatedAt());
    }
}
