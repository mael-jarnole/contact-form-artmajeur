<?php

namespace App\Controller;

use App\Repository\MessageRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    #[Route('/admin', name: 'app_admin')]
    public function index(MessageRepository $messageRepository): Response
    {
        $messages = $messageRepository->findAll();
        $messagesByEmails = [];

        foreach($messages as $message)
        {
            $messagesByEmails[$message->getEmail()][] = $message;
        }

        return $this->render('admin/index.html.twig', [
            'messagesByEmails' => $messagesByEmails,
        ]);
    }
}
