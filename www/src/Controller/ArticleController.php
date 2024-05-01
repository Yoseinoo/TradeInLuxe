<?php

namespace App\Controller;

use App\Repository\TailleRepository;
use App\Repository\ProduitRepository;
use App\Repository\CategorieRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/article')]
class ArticleController extends AbstractController
{
    public function __construct(
        private ProduitRepository $produitRepository,
        private CategorieRepository $categorieRepository,
        private TailleRepository $tailleRepository,
    ) {
    }

    #[Route('/{id}', name: 'app_article')]
    public function index(Request $request): Response
    {
        $id = $request->attributes->get('id');

        $produit = $this->produitRepository->findOneBy(['id' => $id, 'isEnabled' => true, 'deletedAt' => null]);
        
        return $this->render('article/produit.html.twig', [
            'title' => 'Détails',
            'produit' => $produit
        ]);
    }
}
