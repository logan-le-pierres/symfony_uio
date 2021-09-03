<?php

namespace App\Controller;

use App\Form\LoginType;
use App\Controller\SecurityController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class HomeController extends AbstractController
{



    /**
     * @Route("/", name="home_login")
     */
    public function loginpage()
    {
        $user = $this->getUser();
        if ($user === null) {
            return $this->redirectToRoute('security_login');
        } else {
           return $this->redirectToRoute('project');
        }
    }
}
