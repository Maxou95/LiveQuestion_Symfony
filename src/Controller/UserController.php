<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\ProfileType;
use App\Form\UserSearchType;
use App\Form\UserUpdateType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserController extends AbstractController
{
    /**
     * @Route("/users", name="app_users")
     */
    public function index(UserRepository $userRepository, Request $request)
    {
        $searchForm = $this->createForm(UserSearchType::class);
        $searchForm->handleRequest($request);
        $users = $userRepository->findAll();

        if ($searchForm->isSubmitted() && $searchForm->isValid()) {

            $search = $searchForm->getData()->getUsername();
            $datas = $userRepository->search($search);

            if ($datas == null) {
                $this->addFlash('error', 'Aucun utilisateur ne correspond à vos critères de recherche.');
            }

            return $this->render('user/index.html.twig', [
                'searchForm' => $searchForm->createView(),
                "users" => $datas,
            ]);
        }
        
        return $this->render('user/index.html.twig', [
            'searchForm' => $searchForm->createView(),
            "users" => $users,
        ]);

    }
    /**
     * @Route("/user/{id}", name="app_user", requirements={"id"="\d+"})
     */
    public function view(User $user)
    {
        return $this->render('user/view.html.twig', [
            "user" => $user,
        ]);
    }

    /**
     * @Route("/user/update/{id}", name="app_user_update", requirements={"id"="\d+"})
     */
    public function update(User $user, Request $request, EntityManagerInterface $entityManager){
        $form = $this->createForm(ProfileType::class, $user->getProfile());
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
     * @Route("/user/update-logs/{id}", name="app_user_updatelogs", requirements={"id"="\d+"})
     */
    public function updateLogs(User $user, Request $request, EntityManagerInterface $entityManager, UserPasswordEncoderInterface $passwordEncoder){
        $form = $this->createForm(UserUpdateType::class, $user);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $user->setPassword(
                $passwordEncoder->encodePassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );
            $entityManager->persist($user);
            $entityManager->flush();
            $this->addFlash('success',"Vos informations de connexions ont été modifiées.");
            return $this->redirectToRoute("app_user", [
                "id" => $user->getId()
            ]);
        }

        return $this->render('user/updatelogs.html.twig', [
            "user" => $user,
            "form" => $form->createView()
        ]);
    }

    /**
     * @Route("/user/delete/{id}", name="app_user_delete", requirements={"id"="\d+"})
     */
    public function delete(User $user, Request $request, EntityManagerInterface $entityManager, TokenStorageInterface $tokenStorage, SessionInterface $session){
        if($this->isCsrfTokenValid("delete".$user->getId(), $request->get("_token"))){
            $entityManager->remove($user);
            $entityManager->flush();
            $this->addFlash('success','Votre profil a été supprimé.');
            $tokenStorage->setToken(null);
            $session->invalidate();
            
            return $this->redirectToRoute("main");
        }
    }
}
