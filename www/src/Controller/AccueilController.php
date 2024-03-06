<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

class AccueilController extends AbstractController {

    #[Route('/', name: 'app_accueil')]
    public function number(): Response {
        return $this->render('home/index.html.twig', [
            'title' => 'TradeInLuxe',
        ]);
    }
}