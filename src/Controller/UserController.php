<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    #[Route('/users', name: 'user_list', methods: ['GET'])]
    public function list(UserRepository $userRepository): Response
    {
        return $this->json($userRepository->findAll());
    }

    #[Route('/users', name: 'user_create', methods: ['POST'])]
    public function create(Request $request, EntityManagerInterface $entityManager): Response
    {
        $data = json_decode($request->getContent(), true);

        $user = new User();
        $user->setUsername($data['name']);
        $user->setEmail($data['email']);
        $entityManager->persist($user);
        $entityManager->flush();

        return $this->json(['message' => 'Utilisateur créé'], Response::HTTP_CREATED);
    }

    #[Route('/users/{id}', name: 'user_delete', methods: ['DELETE'])]
    public function delete(User $user, EntityManagerInterface $entityManager): Response
    {
        $entityManager->remove($user);
        $entityManager->flush();

        return $this->json(['message' => 'Utilisateur supprimé'], Response::HTTP_NO_CONTENT);
    }
}
