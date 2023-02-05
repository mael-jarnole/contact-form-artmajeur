<?php

namespace App\Controller;

use App\Entity\Message;
use App\Form\Type\MessageType;
use App\Repository\MessageRepository;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends AbstractController
{

    /**
     * @param Request $request
     * @return Response
     */
    #[Route('/', name: 'homepage')]
    public function homePage(Request $request): Response
    {
        $message = $request->getSession()->get('message');
        if (!$message instanceof Message) {
            return $this->render('base/home.html.twig', [
                "message" => null
            ]);
        } else {
            $request->getSession()->set('message', null);
            return $this->render('base/home.html.twig', [
                "message" => $message
            ]);
        }

    }

    /**
     * @param MessageRepository $messageRepository
     * @param Request $request
     * @return Response
     * @throws Exception
     */
    #[Route('/contact', name: 'contact')]
    public function contactPage(
        MessageRepository $messageRepository,
        Request           $request
    ): Response
    {
        $form = $this->createForm(MessageType::class, null, [
            'action' => $this->generateUrl('contact')
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $contactMessage = $form->getData();

            if ($contactMessage instanceof Message) {
                $messageRepository->save($contactMessage);
                $request->getSession()->set('message', $contactMessage);
                return $this->redirectToRoute('homepage');
            } else {
                throw new Exception("The contact message is not a valid object");
            }
        } else {
            return $this->render('base/contact.html.twig', [
                'form' => $form,
                'message' => null
            ]);
        }
    }
}