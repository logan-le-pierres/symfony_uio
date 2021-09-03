<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;

class ProjectController extends AbstractController
{
    /**
     * @Route("/user", name="user")
     */
    public function user(): Response
    {
        $user = $this->getUser();
        if ($user === null) {
            return $this->redirectToRoute('security_login');
        } else {
            return $this->redirectToRoute('user_table');
        }
    }
    /**
     * @Route("/user/table", name="user_table")
     */
    public function recoverData(UserRepository $userRepository)
    {
        $user = $this->getUser();
        if ($user === null){
            return $this->redirectToRoute('security_login');
        } else {

        
        //ICI tu va bien récupérer une collections d'utilisateurs donc user avec s = users
        $users = $userRepository->findAll();
        // ICI on passe la variable au twig qui va permettre de venir récupérer les données
        return $this->render('user/index.html.twig', [
            'users' => $users
        ]);
    }
    }
}
