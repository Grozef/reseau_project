<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Entity\SocialAccount;
use App\Entity\Post;
use App\Entity\Message;
use App\Entity\Media;
use App\Entity\Platform;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // Création de 2 utilisateurs
        $user1 = new User();
        $user1->setUserName('JohnDoe')
              ->setEmail('john.doe@example.com')
              ->setPassword('securepassword');
        $manager->persist($user1);

        $user2 = new User();
        $user2->setUserName('JaneDoe')
              ->setEmail('jane.doe@example.com')
              ->setPassword('securepassword2');
        $manager->persist($user2);

        // Création de 2 plateformes
        $platform1 = new Platform();
        $platform1->setName('Facebook')
                  ->setApiUrl('https://api.facebook.com')
                  ->setDescription('Social Media Platform')
                  ->setCreatedAt(new \DateTimeImmutable());
        $manager->persist($platform1);

        $platform2 = new Platform();
        $platform2->setName('Instagram')
                  ->setApiUrl('https://api.instagram.com')
                  ->setDescription('Photo Sharing Platform')
                  ->setCreatedAt(new \DateTimeImmutable());
        $manager->persist($platform2);

        // Création de comptes sociaux
        $account1 = new SocialAccount();
        $account1->setPlatform('Facebook')
                 ->setAccountName('JohnDoeFB')
                 ->setAccessToken('dummy-token-fb')
                 ->setCreatedAt(new \DateTimeImmutable())
                 ->setRelation($user1)
                 ->setSocialAccountPlatform($platform1);
        $manager->persist($account1);

        $account2 = new SocialAccount();
        $account2->setPlatform('Instagram')
                 ->setAccountName('JaneDoeIG')
                 ->setAccessToken('dummy-token-ig')
                 ->setCreatedAt(new \DateTimeImmutable())
                 ->setRelation($user2)
                 ->setSocialAccountPlatform($platform2);
        $manager->persist($account2);

        // Création de 2 posts
        $post1 = new Post();
        $post1->setContent('First post from John')
              ->setScheduledAt(new \DateTimeImmutable('2025-01-15T10:00:00'))
              ->setStatus('draft')
              ->setCreatedAt(new \DateTimeImmutable())
              ->setRelation($account1);
        $manager->persist($post1);

        $post2 = new Post();
        $post2->setContent('First post from Jane')
              ->setScheduledAt(new \DateTimeImmutable('2025-01-20T14:00:00'))
              ->setStatus('published')
              ->setCreatedAt(new \DateTimeImmutable())
              ->setRelation($account2);
        $manager->persist($post2);

        // Création de médias
        $media1 = new Media();
        $media1->setFilePath('uploads/john_image.jpg')
               ->setType('image/jpeg')
               ->setCreatedAt(new \DateTimeImmutable());
        $manager->persist($media1);

        $media2 = new Media();
        $media2->setFilePath('uploads/jane_video.mp4')
               ->setType('video/mp4')
               ->setCreatedAt(new \DateTimeImmutable());
        $manager->persist($media2);

        // Création de messages
        $message1 = new Message();
        $message1->setMessageId('MSG123')
                 ->setContent('Hello from John')
                 ->setSender(['name' => 'John'])
                 ->setRecipient(['name' => 'Jane'])
                 ->setStatus('sent')
                 ->setCreatedAt(new \DateTimeImmutable())
                 ->setRelation($account1)
                 ->setMedia($media1);
        $manager->persist($message1);

        $message2 = new Message();
        $message2->setMessageId('MSG456')
                 ->setContent('Reply from Jane')
                 ->setSender(['name' => 'Jane'])
                 ->setRecipient(['name' => 'John'])
                 ->setStatus('delivered')
                 ->setCreatedAt(new \DateTimeImmutable())
                 ->setRelation($account2)
                 ->setMedia($media2);
        $manager->persist($message2);

        // Appliquer toutes les modifications
        $manager->flush();
    }
}
