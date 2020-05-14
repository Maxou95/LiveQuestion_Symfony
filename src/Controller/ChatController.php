<?php

namespace App\Controller;

use App\Entity\Conversation;
use App\Entity\Message;
use App\Entity\User;
use App\Form\ConversationSearchType;
use App\Form\MessageType;
use App\Form\NewConversationType;
use App\Repository\ConversationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class ChatController extends AbstractController
{
    /**
     * @Route("/chat", name="app_chat_main")
     */
    public function index(ConversationRepository $conversationRepository, Request $request)
    {
        $searchForm = $this->createForm(ConversationSearchType::class);
        $searchForm->handleRequest($request);
        $conversations = $conversationRepository->findBy([], ['created' => 'DESC']);

        if($searchForm->isSubmitted() && $searchForm->isValid()){
            $search = $searchForm->getData()->getName();
            $datas = $conversationRepository->search($search);

            if ($datas == null) {
                $this->addFlash('error', 'Aucune conversation ne correspond à vos critères de recherche.');
            }
            
            return $this->render('chat/index.html.twig', [
                'conversations' => $datas,
                'searchForm' => $searchForm->createView(),
                'searchFormSubmitted' => true
            ]);
        }
        return $this->render('chat/index.html.twig', [
            'conversations' => $conversations,
            'searchForm' => $searchForm->createView(),
            'searchFormSubmitted' => false
        ]);
    }

    /**
     * @Route("/chat/new", name="app_new_chat")
     */
    public function newConversation(Request $request)
    {
        $conversation = new Conversation();
        $form = $this->createForm(NewConversationType::class, $conversation);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $conversation->setCreated(new \DateTime());
            $conversation->getParticipants()->add($this->getUser());
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($conversation);
            $entityManager->flush();
            return $this->redirectToRoute("app_chat", ['id' => $conversation->getId()]);
        }

        return $this->render('chat/new.html.twig', [
            'conversationForm' => $form->createView(),
        ]);
    }

    /**
     * @Route("/chat/{id}", name="app_chat", requirements={"id"="\d+"})
     */
    public function conversation(Conversation $conversation, Request $request)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $form = null;
        if($this->isGranted("IS_AUTHENTICATED_FULLY"))
        {
            $message = new Message();
            $form = $this->createForm(MessageType::class, $message);
            $form->handleRequest($request);

            if($form->isSubmitted() && $form->isValid())
            {
                $message->setSender($this->getUser());
                $message->setConversation($conversation);
                $message->setCreated(new \DateTime());

                $entityManager->persist($message);
                $entityManager->flush();
                return $this->redirectToRoute("app_chat", ['id' => $conversation->getId()]);
            }

            $form = $form->createView();
        }

        $entityManager->persist($conversation);
        $entityManager->flush();

        return $this->render('chat/view.html.twig', [
            'conversation' => $conversation,
            'messageForm' => $form,
        ]);
    }

    


}
