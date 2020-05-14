<?php

namespace App\Controller;

use App\Form\ConversationSearchType;
use App\Form\QuestionSearchType;
use App\Repository\ConversationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\QuestionRepository;
use Symfony\Component\HttpFoundation\Request;

class MainController extends AbstractController
{
    /**
     * @Route("/", name="main")
     */
    public function index(QuestionRepository $questionRepository, ConversationRepository $conversationRepository, Request $request)
    {
        $searchForm = $this->createForm(QuestionSearchType::class);
        $searchForm->handleRequest($request);
        $questions = $questionRepository->findBy([], ['created' => 'DESC']);
        
        $searchFormConv = $this->createForm(ConversationSearchType::class);
        $searchFormConv->handleRequest($request);

        if ($searchForm->isSubmitted() && $searchForm->isValid()) {
 
            $search = $searchForm->getData()->getQuestion();

            $datas = $questionRepository->search($search);

            return $this->render('main/index.html.twig', [
                'searchForm' => $searchForm->createView(),
                'questions' => $datas,
                'searchFormConv' => $searchFormConv->createView(),
                'formSubmitted' => true,
                'formConvSubmitted' => false,
            ]);
        }

        if ($searchFormConv->isSubmitted() && $searchFormConv->isValid()) {
 
            $search = $searchFormConv->getData()->getName();

            $datas = $conversationRepository->search($search);

            return $this->render('main/index.html.twig', [
                'searchForm' => $searchForm->createView(),
                'searchFormConv' => $searchFormConv->createView(),
                'questions' => $questions,
                'conversations' => $datas,
                'formSubmitted' => false,
                'formConvSubmitted' => true,
            ]);
        }
        
        return $this->render('main/index.html.twig', [
            'searchForm' => $searchForm->createView(),
            'searchFormConv' => $searchFormConv->createView(),
            'questions' => $questions,
            'formSubmitted' => false,
            'formConvSubmitted' => false,
        ]);
    }
}

