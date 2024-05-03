<?php

namespace App\Controller;

use App\Repository\CategorieRepository;
use App\Repository\CouleurRepository;
use App\Repository\MarqueRepository;
use App\Repository\ProduitRepository;
use App\Repository\TailleRepository;
use Pagerfanta\Doctrine\ORM\QueryAdapter;
use Pagerfanta\Pagerfanta;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class CategorieController extends AbstractController
{
    public function __construct(
        private ProduitRepository $produitRepository,
        private CategorieRepository $categorieRepository,
        private MarqueRepository $marqueRepository,
        private TailleRepository $tailleRepository,
        private CouleurRepository $couleurRepository
    ) {
    }

    #[Route('/chaussures/{page<\d+>}', name: 'app_chaussures')]
    public function chaussures(Request $request, int $page = 1): Response
    {
        $formData = [];
        if ($request->isMethod('POST')) {
            $formData = $request->request->all();
        }else{
            $formData = $request->query->all() != null ? $request->query->all() : [];
        }

        $template = $request->isXmlHttpRequest() ? '_list.html.twig' : 'index.html.twig';

        $data = $this->getFiltres('Chaussures');
        $pagerfanta = $this->getProduitsPager($data['categorie'], $page, $formData);

        return $this->render('categorie/'.$template, [
            'title' => 'Chaussures',
            'description' => $data['description'],
            'pager' => $pagerfanta,
            'filtresParType' => $data['filtresParType'],
            'selected' => $formData
        ]);
    }

    #[Route('/sacs/{page<\d+>}', name: 'app_sacs')]
    public function sacs(Request $request, int $page = 1): Response
    {
        $formData = [];
        if ($request->isMethod('POST')) {
            $formData = $request->request->all();
        }else{
            $formData = $request->query->all() != null ? $request->query->all() : [];
        }

        $template = $request->isXmlHttpRequest() ? '_list.html.twig' : 'index.html.twig';

        $data = $this->getFiltres('Sacs');
        $pagerfanta = $this->getProduitsPager($data['categorie'], $page, $formData);

        return $this->render('categorie/'.$template, [
            'title' => 'Sacs',
            'description' => $data['description'],
            'pager' => $pagerfanta,
            'filtresParType' => $data['filtresParType'],
            'selected' => $formData
        ]);
    }

    #[Route('/vetements/{page<\d+>}', name: 'app_vetements')]
    public function vetements(Request $request, int $page = 1): Response
    {
        $formData = [];
        if ($request->isMethod('POST')) {
            $formData = $request->request->all();
        }else{
            $formData = $request->query->all() != null ? $request->query->all() : [];
        }

        $template = $request->isXmlHttpRequest() ? '_list.html.twig' : 'index.html.twig';

        $data = $this->getFiltres('Vêtements');
        $pagerfanta = $this->getProduitsPager($data['categorie'], $page, $formData);

        return $this->render('categorie/'.$template, [
            'title' => 'Vêtements',
            'description' => $data['description'],
            'pager' => $pagerfanta,
            'filtresParType' => $data['filtresParType'],
            'selected' => $formData
        ]);
    }

    private function getFiltres(string $categorieName): array
    {
        $categorie = $this->categorieRepository->getOne("name=$categorieName")->getId();
        $description = $this->categorieRepository->getOne("name=$categorieName")->getDescription();
        $marques = $this->marqueRepository->findBy(['deletedAt' => null, 'isEnabled' => true]);
        $tailles = $this->tailleRepository->findBy(['categorie' => $categorie,'deletedAt' => null, 'isEnabled' => true]);
        $couleurs = $this->couleurRepository->findBy(['deletedAt' => null, 'isEnabled' => true],['name' => 'ASC']);
        
        $filtres = [
            'Marques' => $marques,
            // 'Tailles' => $tailles,
            'Couleurs'=> $couleurs
        ];

        foreach ($filtres as $key => $filtre) {
            foreach ($filtre as $row){
                $filtresParType[$key][] = $row;
            }
        }
       
        return [
            'filtresParType' => $filtresParType,
            'categorie' => $categorie,
            'description' => $description
        ];
    }

    private function getProduitsPager(int $idCategorie, int $page, array $filtres = null): Pagerfanta
    {
        $params = "categorie=$idCategorie&deleted=false&enabled=true";

        $queryBuilder = $this->produitRepository->getAllQueryBuilder($params, $filtres);
        $pagerfanta = new Pagerfanta(new QueryAdapter($queryBuilder));
        $pagerfanta->setMaxPerPage(12);
        $pagerfanta->getNbPages() > 1 ? $pagerfanta->setCurrentPage($page) : '';

        return $pagerfanta;
    }

}
