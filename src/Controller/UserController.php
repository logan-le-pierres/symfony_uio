<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class UserController extends AbstractController
{
    // AbstractController permet ici de ne pas avoir a définir render(), 
    //elle est donc ici a disposition via $this->render()

    /**
     *@Route("/user", name="utilisateur")
     */
    public function user()
    {

        return $this->render('user.html.twig');
    }
}
