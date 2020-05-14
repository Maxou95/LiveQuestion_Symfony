<?php

namespace App\Controller;

use App\Form\QuestionSearchType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\QuestionRepository;
use Symfony\Component\HttpFoundation\Request;

class MainController extends AbstractController
{
    /**
     * @Route("/", name="main")
     */
    public function index(QuestionRepository $questionRepository, Request $request)
    {
        $searchForm = $this->createForm(QuestionSearchType::class);
        $searchForm->handleRequest($request);
        $questions = $questionRepository->findBy([], ['created' => 'DESC']);
        
        if ($searchForm->isSubmitted() && $searchForm->isValid()) {
 
            $search = $searchForm->getData()->getQuestion();

            $datas = $questionRepository->search($search);

            return $this->render('main/index.html.twig', [
                'searchForm' => $searchForm->createView(),
                'questions' => $datas,
                'formSubmitted' => true,
            ]);
        }
        
        return $this->render('main/index.html.twig', [
            'searchForm' => $searchForm->createView(),
            'questions' => $questions,
            'formSubmitted' => false,
        ]);
    }
}

