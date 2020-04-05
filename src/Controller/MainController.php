<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\QuestionRepository;

class MainController extends AbstractController
{
    /**
     * @Route("/", name="main")
     */
    public function index(QuestionRepository $questionRepository)
    {
        $questions = $questionRepository->findBy([], ['created' => 'DESC']);
        return $this->render('main/index.html.twig', [
            'questions' => $questions,
        ]);
    }
}
