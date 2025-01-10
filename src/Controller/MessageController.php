<?php

namespace App\Controller;

use App\Entity\Message;
use App\Repository\MessageRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MessageController extends AbstractController
{
    #[Route('/messages', name: 'message_list', methods: ['GET'])]
    public function list(MessageRepository $repository): Response
    {
        return $this->json($repository->findAll());
    }
}
