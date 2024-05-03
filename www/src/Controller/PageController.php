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

    #[Route('/a-propos', name: 'app_about')]
    public function about(): Response {
        return $this->render('page/about.html.twig', [
        ]);
    }

    #[Route('/FAQ', name: 'app_faq')]
    public function faq(Request $request): Response {

        $question = $request->query->get('faq');

        return $this->render('page/FAQ/faq.html.twig', [
            'question' => $question
        ]);
    }

    #[Route('/politique-de-confidentialite', name: 'app_politique')]
    public function politique(): Response {

        return $this->render('page/politiques.html.twig', [
        ]);
    }

    #[Route('/cgu', name: 'app_cgu')]
    public function cgu(): Response {

        return $this->render('page/cgu.html.twig', [
        ]);
    }

    #[Route('/certification-luxe', name: 'app_certification')]
    public function certification(): Response {

        return $this->render('page/certification.html.twig', [
        ]);
    }
}