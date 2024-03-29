<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

class HomeController extends AbstractController {

    #[Route('/')]
    public function number(): Response {
        return $this->render('home/index.html.twig', [
            'title' => 'TradeInLuxe',
        ]);
    }
}