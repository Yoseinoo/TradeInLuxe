<?php

namespace App\Controller;

use Pagerfanta\Pagerfanta;
use App\Repository\EtatRepository;
use App\Repository\TailleRepository;
use App\Repository\ArticleRepository;
use App\Repository\ProduitRepository;
use App\Repository\CategorieRepository;
use Pagerfanta\Doctrine\ORM\QueryAdapter;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/article')]
class ArticleController extends AbstractController
{
    public function __construct(
        private ProduitRepository $produitRepository,
        private ArticleRepository $articleRepository,
        private CategorieRepository $categorieRepository,
        private TailleRepository $tailleRepository,
        private EtatRepository $etatRepository,
    ) {
    }

    #[Route('/{id}/{page<\d+>}', name: 'app_article')]
    public function index(Request $request, int $page = 1): Response
    {
        $id = $request->attributes->get('id');

        $produit = $this->produitRepository->findOneBy(['id' => $id, 'isEnabled' => true, 'deletedAt' => null]);
        $idCategorie = $produit->getCategorie()->getId();

        $formData = [];
        if ($request->isMethod('POST')) {
            $formData = $request->request->all();
        }else{
            $formData = $request->query->all() != null ? $request->query->all() : [];
        }

        $template = $request->isXmlHttpRequest() ? '_list.html.twig' : 'index.html.twig';

        $data = $this->getFiltres($idCategorie);
        $pagerfanta = $this->getProduitsPager($id, $page, $formData);

        return $this->render('article/'.$template, [
            'title' => 'Détails',
            'produit' => $produit,
            'pager' => $pagerfanta,
            'filtresParType' => $data['filtresParType'],
            'selected' => $formData
        ]);
    }

    #[Route('/details/{id}/{idArticle}/{page<\d+>}', name: 'app_article_detail')]
    public function article(Request $request, int $page = 1): Response
    {

        $id = $request->attributes->get('id');
        $idArticle = $request->attributes->get('idArticle');

        $produit = $this->produitRepository->findOneBy(['id' => $id, 'isEnabled' => true, 'deletedAt' => null]);
        $idCategorie = $produit->getCategorie()->getId();
        $article = $this->articleRepository->findOneBy(['id' => $idArticle, 'isEnabled' => true, 'deletedAt' => null, 'isValidated'=> true]);

        $formData = [];
        if ($request->isMethod('POST')) {
            $formData = $request->request->all();
        }else{
            $formData = $request->query->all() != null ? $request->query->all() : [];
        }

        $template = $request->isXmlHttpRequest() ? '_list.html.twig' : 'index.html.twig';

        $data = $this->getFiltres($idCategorie);
        $pagerfanta = $this->getProduitsPager($id, $page, $formData);

        return $this->render('article/'.$template, [
            'article' => $article,
            'title' => 'Détails',
            'produit' => $produit,
            'pager' => $pagerfanta,
            'filtresParType' => $data['filtresParType'],
            'selected' => $formData
        ]);
    }

    private function getFiltres(int $categorieId): array
    {
        $tailles = $this->tailleRepository->findBy(['categorie' => $categorieId,'deletedAt' => null, 'isEnabled' => true]);
        $etat = $this->etatRepository->findBy(['deletedAt' => null, 'isEnabled' => true]);
        $filtres = [
            'Tailles' => $tailles,
            'Etat' => $etat
        ];

        foreach ($filtres as $key => $filtre) {
            foreach ($filtre as $row){
                $filtresParType[$key][] = $row;
            }
        }
       
        return [
            'filtresParType' => $filtresParType
        ];
    }

    private function getProduitsPager(int $idProduit, int $page, array $filtres = null): Pagerfanta
    {
        $params = "produit=$idProduit&deleted=false&isEnabled=true&isValidated=true";

        $queryBuilder = $this->articleRepository->getAllQueryBuilder($params, $filtres);
        $pagerfanta = new Pagerfanta(new QueryAdapter($queryBuilder));
        $pagerfanta->setMaxPerPage(12);
        $pagerfanta->getNbPages() > 1 ? $pagerfanta->setCurrentPage($page) : '';

        return $pagerfanta;
    }
}
