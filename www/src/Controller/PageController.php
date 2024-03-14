<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

class PageController extends AbstractController {

    #[Route('/', name: 'app_accueil')]
    public function accueil(): Response {
        return $this->render('page/accueil.html.twig', [
            
        ]);
    }

    #[Route('/about', name: 'app_about')]
    public function about(): Response {
        return $this->render('page/about.html.twig', [
        ]);
    }
}