<?php

namespace App\Controller;

use App\Entity\Post;
use App\Entity\SocialAccount;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PostController extends AbstractController
{
    #[Route('/posts', name: 'post_list', methods: ['GET'])]
    public function list(EntityManagerInterface $entityManager): Response
    {
        $posts = $entityManager->getRepository(Post::class)->findAll();
        return $this->json($posts);
    }

    #[Route('/posts', name: 'post_create', methods: ['POST'])]
    public function create(Request $request, EntityManagerInterface $entityManager): Response
    {
        $data = json_decode($request->getContent(), true);

        $account = $entityManager->getRepository(SocialAccount::class)->find($data['social_account_id']);
        if (!$account) {
            return $this->json(['error' => 'Compte social non trouvé'], Response::HTTP_NOT_FOUND);
        }

        $post = new Post();
        $post->setContent($data['content']);
        $post->setScheduledAt(new \DateTimeImmutable($data['scheduled_at']));
        $post->setRelation($account);

        $entityManager->persist($post);
        $entityManager->flush();

        return $this->json(['message' => 'Publication créée'], Response::HTTP_CREATED);
    }
}
