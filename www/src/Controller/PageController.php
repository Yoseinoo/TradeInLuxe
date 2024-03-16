<?php

namespace App\Controller;

use App\Repository\ProduitRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PageController extends AbstractController {

    #[Route('/', name: 'app_accueil')]
    public function accueil(): Response {
        return $this->render('page/accueil.html.twig', [
            
        ]);
    }

    #[Route('/search', name: 'app_search')]
    public function search(Request $request, ProduitRepository $produitRepository): Response {

        $searchTerm = $request->query->get('q');
        $produits = $produitRepository->getAll(
           "search=$searchTerm&deleted=false&enabled=true"
            
        );

        if($searchTerm == ''){
            $produits = [];
        }

        if ($request->query->get('preview')) {
           
            return $this->render('partials/_searchPreview.html.twig', [
                'produits' => $produits,
            ]);
        }

        return $this->render('page/accueil.html.twig', [
            
        ]);
    }

    #[Route('/about', name: 'app_about')]
    public function about(): Response {
        return $this->render('page/about.html.twig', [
        ]);
    }
}