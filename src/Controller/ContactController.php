<?php

namespace App\Controller;

use App\Entity\Message;
use App\Form\Type\MessageType;
use App\Service\ContactMessageService;
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
        // check if a message has been stored in session
        // because it was previously sent by user
        $message = $request->getSession()->get('message');

        // if it was set, delete it. we are about to handle it
        if (isset($message)) {
            $request->getSession()->set('message', null);
        }

        // Renders the homepage with an alert with the message if there was one
        return $this->render('base/home.html.twig', [
            "message" => $message instanceof Message ? $message : null
        ]);

    }

    /**
     * @param ContactMessageService $contactMessageService
     * @param Request $request
     * @return Response
     * @throws Exception
     */
    #[Route('/contact', name: 'contact')]
    public function contactPage(
        ContactMessageService $contactMessageService,
        Request               $request
    ): Response
    {
        $form = $this->createForm(MessageType::class, null, [
            'action' => $this->generateUrl('contact')
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $contactMessage = $form->getData();

            if ($contactMessage instanceof Message) {
                // store in session
                $request->getSession()->set('message', $contactMessage);
                // handle message
                $contactMessageService->createMessage($contactMessage);
                // redirect to homepage
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