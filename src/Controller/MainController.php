<?php

namespace App\Controller;

use App\Form\ConversationSearchType;
use App\Repository\ConversationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class MainController extends AbstractController
{
    /**
     * @Route("/", name="main")
     */
    public function index(ConversationRepository $conversationRepository, Request $request)
    {
        $searchFormConv = $this->createForm(ConversationSearchType::class);
        $searchFormConv->handleRequest($request);

        if ($searchFormConv->isSubmitted() && $searchFormConv->isValid()) {
 
            $search = $searchFormConv->getData()->getName();
            $datas = $conversationRepository->search($search);

            return $this->render('main/index.html.twig', [
                'searchFormConv' => $searchFormConv->createView(),
                'conversations' => $datas,
                'formConvSubmitted' => true,
            ]);
        }
        
        return $this->render('main/index.html.twig', [
            'searchFormConv' => $searchFormConv->createView(),
            'formConvSubmitted' => false,
        ]);
    }
}

