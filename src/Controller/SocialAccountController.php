<?php

namespace App\Controller;

use App\Entity\SocialAccount;
use App\Entity\User;
use App\Entity\Platform;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SocialAccountController extends AbstractController
{
    #[Route('/social-accounts', name: 'social_account_create', methods: ['POST'])]
    public function create(Request $request, EntityManagerInterface $entityManager): Response
    {
        $data = json_decode($request->getContent(), true);
    
        // Vérifier l'utilisateur
        $user = $entityManager->getRepository(User::class)->find($data['user_id']);
        if (!$user) {
            return $this->json(['error' => 'Utilisateur non trouvé'], Response::HTTP_NOT_FOUND);
        }
    
        // Vérifier la plateforme
        $platform = $entityManager->getRepository(Platform::class)->find($data['platform_id']);
        if (!$platform) {
            return $this->json(['error' => 'Plateforme non trouvée'], Response::HTTP_NOT_FOUND);
        }
    
        // Créer le compte social
        $account = new SocialAccount();
        $account->setSocialAccountPlatform($platform); // Associer à une entité Platform
        $account->setPlatform($platform->getName()); // Facultatif : Stocker le nom de la plateforme si nécessaire
        $account->setAccountName($data['username']); // Champ correspondant à `account_name`
        $account->setRelation($user);
        $account->setCreatedAt(new \DateTimeImmutable());
    
        $entityManager->persist($account);
        $entityManager->flush();
    
        return $this->json(['message' => 'Compte social ajouté'], Response::HTTP_CREATED);
    }
}    