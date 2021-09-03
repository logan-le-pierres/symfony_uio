<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminController extends AbstractController
{
    // AbstractController permet ici de ne pas avoir a définir render(), 
    //elle est donc ici a disposition via $this->render()

    /**
     *@Route("/admin/superadmin", name="superAdmin")
     */
    public function admin()
    {

        return $this->render('admin.html.twig');
    }
}
