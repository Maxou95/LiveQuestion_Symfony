<?php

namespace App\Controller;

use App\Entity\Profile;
use App\Entity\User;
use App\Form\ProfileType;
use App\Form\UserType;
use App\Repository\QuestionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;


class UserController extends AbstractController
{
    /**
     * @Route("/user/{id}", name="app_user", requirements={"id"="\d+"})
     */
    public function index(User $user, QuestionRepository $questionRepository)
    {
        $questions = $questionRepository->findByUserId($user->getId());
        return $this->render('user/index.html.twig', [
            "user" => $user,
            "questions" => $questions,
        ]);
    }

    /**
     * @Route("/user/update/{id}", name="app_user_update", requirements={"id"="\d+"})
     */
    public function update(User $user, Request $request, EntityManagerInterface $entityManager){
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $entityManager->persist($user);
            $entityManager->flush();
            $this->addFlash('success',"Votre profil a été modifié.");
            return $this->redirectToRoute("app_user", [
                "id" => $user->getId()
            ]);
        }

        return $this->render('user/update.html.twig', [
            "user" => $user,
            "form" => $form->createView()
        ]);
    }

    /**
     * @Route("/user/profile/{id}", name="app_profil_update", requirements={"id"="\d+"})
     */
    public function profil(Profile $profile, Request $request, EntityManagerInterface $entityManager)
    {
        $user = $this->getUser();
        $form = $this->createForm(ProfileType::class, $profile);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $entityManager->persist($profile);
            $entityManager->persist($user);
            $entityManager->flush();
            $this->addFlash('success',"Votre profil a été modifié.");
            return $this->redirectToRoute("app_user", [
                "id" => $user->getId()
            ]);
        }

        return $this->render('user/profil.html.twig', [
            "profile" => $profile,
            "form" => $form->createView()
        ]);
    }
}
