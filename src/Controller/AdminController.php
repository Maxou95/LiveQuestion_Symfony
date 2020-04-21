<?php

namespace App\Controller;

use App\Entity\Question;
use App\Repository\QuestionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Request;

class AdminController extends AbstractController
{
    /**
     * @Route("/admin", name="admin")
     * @IsGranted("ROLE_ADMIN")
     */
    public function index()
    {
        return $this->render('admin/index.html.twig');
    }

    /**
     * @Route("/admin/questions", name="admin_questions")
     */
    public function moderateQuestion(QuestionRepository $questionRepository)
    {
        
        $questions = $questionRepository->findBy([], ['created' => 'DESC']);
        return $this->render('admin/questions.html.twig', [
            'questions' => $questions,
        ]);
    }

    /**
     * @Route("/admin/questions/delete/{id}", name="admin_delete_question", methods="delete")
     */
    public function removeQuestion(Question $question, Request $request, EntityManagerInterface $entityManager)
    {
        if($this->isCsrfTokenValid("delete".$question->getId(), $request->get("_token"))){
            $entityManager->remove($question);
            $entityManager->flush();
            $this->addFlash('success','La question a été supprimée.');
            return $this->redirectToRoute("admin_questions");
        }
    }
}
