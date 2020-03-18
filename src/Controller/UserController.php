<?php

namespace App\Controller;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    /**
     * @Route("/user/{id}", name="user")
     */
    public function showUser(User $user)
    {
        return $this->render('user/index.html.twig', [
            'user' => $user
        ]);
    }
}
