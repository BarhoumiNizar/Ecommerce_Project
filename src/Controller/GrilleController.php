<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GrilleController extends AbstractController
{
    /**
     * @Route("/", name="grille")
     */
    public function index(): Response
    {
        return $this->render('grille/index.html.twig');
    }
    /**
     * @Route("/admin", name="adminHome")
     */
    public function Admin(): Response
    {
        return $this->render('admin.html.twig');
    }


}
