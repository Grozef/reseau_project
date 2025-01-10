<?php

namespace App\Controller;

use App\Entity\Media;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;

class MediaController extends AbstractController
{
    #[Route('/media', name: 'media_upload', methods: ['POST'])]
    public function upload(Request $request, EntityManagerInterface $entityManager): Response
    {
        $file = $request->files->get('file');
        if (!$file) {
            return $this->json(['error' => 'Aucun fichier uploadé'], Response::HTTP_BAD_REQUEST);
        }

        $filename = uniqid() . '.' . $file->guessExtension();
        $file->move($this->getParameter('media_directory'), $filename);

        $media = new Media();
        $media->setFilePath($filename);

        $entityManager->persist($media);
        $entityManager->flush();

        return $this->json(['message' => 'Fichier uploadé avec succès'], Response::HTTP_CREATED);
    }
}
