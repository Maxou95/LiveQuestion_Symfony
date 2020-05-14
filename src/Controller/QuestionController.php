<?php

namespace App\Controller;

use App\Entity\Answer;
use App\Entity\AnswerLike;
use App\Entity\Question;
use App\Entity\QuestionLike;
use App\Form\AnswerType;
use App\Form\QuestionType;
use App\Repository\QuestionLikeRepository;
use App\Repository\AnswerLikeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class QuestionController extends AbstractController
{
    /**
     * @Route("/question/{id}", name="app_question", requirements={"id"="\d+"})
     */
    public function index(Question $question, Request $request)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $renderedForm = null;
        if($this->isGranted("IS_AUTHENTICATED_FULLY"))
        {
            $answer = new Answer();
            $form = $this->createForm(AnswerType::class, $answer);
            $form->handleRequest($request);

            if($form->isSubmitted() && $form->isValid())
            {
                $answer->setUser($this->getUser());
                $answer->setQuestion($question);

                $entityManager->persist($answer);
                $entityManager->flush();
                return $this->redirectToRoute("app_question", ['id' => $question->getId()]);
            }

            $renderedForm = $form->createView();
        }

        $question->setViews($question->getViews() + 1);

        $entityManager->persist($question);
        $entityManager->flush();

        return $this->render('question/index.html.twig', [
            'question' => $question,
            'answerForm' => $renderedForm
        ]);
    }


    /**
     * @Route("/question/ask", name="app_question_ask")
     * @IsGranted("IS_AUTHENTICATED_FULLY")
     */
    public function askQuestion(Request $request)
    {
        $question = new Question();
        $form = $this->createForm(QuestionType::class, $question);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $question->setUser($this->getUser());
            $question->setCreated(new \DateTime());

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($question);
            $entityManager->flush();
            return $this->redirectToRoute("app_question", ['id' => $question->getId()]);
        }

        return $this->render('question/ask.html.twig', [
            'questionForm' => $form->createView()
        ]);
    }

     /**
     * @Route("/answer/{id}/like", name="app_answer_like", requirements={"id"="\d+"})
     * @IsGranted("IS_AUTHENTICATED_FULLY")
     */
    public function answerLike(Answer $answer, EntityManagerInterface $entityManager, AnswerLikeRepository $likes) : Response
    {
        $user=$this->getUser();

        if($answer->isLikedByUser($user)){
            $like = $likes->findOneBy([
                'question' => $answer,
                'user' => $user
            ]);
            $entityManager->remove($like);
            $entityManager->flush();
            
            return $this->json([
                'code' => 200,
                'message' => "Le like a bien été supprimé",
                'likes' => $likes->count(['answer' => $answer])
            ], 200);

        }

        $like = new AnswerLike();
        $like->setAnswer($answer)
            ->setUser($user);

        $entityManager->persist($like);
        $entityManager->flush();

        return $this->json([
            'code' => 200,
            'message' => "Le like a bien été ajouté",
            'likes' => $likes->count(['answer' => $answer])
        ], 200);
    }

    /**
     * @Route("/question/{id}/like", name="app_question_like", requirements={"id"="\d+"})
     * @IsGranted("IS_AUTHENTICATED_FULLY")
     */
    public function like(Question $question, EntityManagerInterface $entityManager, QuestionLikeRepository $likes) : Response
    {
        $user=$this->getUser();

        if($question->isLikedByUser($user)){
            $like = $likes->findOneBy([
                'question' => $question,
                'user' => $user
            ]);
            $entityManager->remove($like);
            $entityManager->flush();
            
            return $this->json([
                'code' => 200,
                'message' => "Le like a bien été supprimé",
                'likes' => $likes->count(['question' => $question])
            ], 200);

        }

        $like = new QuestionLike();
        $like->setQuestion($question)
            ->setUser($user);

        $entityManager->persist($like);
        $entityManager->flush();

        return $this->json([
            'code' => 200,
            'message' => "Le like a bien été ajouté",
            'likes' => $likes->count(['question' => $question])
        ], 200);
    }
}
