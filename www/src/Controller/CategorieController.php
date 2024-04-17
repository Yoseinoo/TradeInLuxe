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
        }

        $template = $request->isXmlHttpRequest() ? '_list.html.twig' : 'index.html.twig';

        $data = $this->getFiltres('Chaussures');
        $pagerfanta = $this->getProduitsPager($data['categorie'], $page, $formData);

        return $this->render('categorie/'.$template, [
            'title' => 'Chaussures',
            'description' => 'La collection de chaussures propose des bottes, ballerines, chaussures à talon, mocassins, chaussures oxford, sandales et claquettes. Les chaussures sont proposées par des marques de créateurs telles que Balenciaga, Prada, Hermès, Louis Vuitton, Timberland, Versace, Crocs, Birkenstock, Chanel, Dior, Gucci et Dr. Martens. La collection de chaussures comprend des chaussures de course, des chaussures de golf, des bottes de randonnée, des chaussures de football et des chaussures de basketball. Les chaussures sont fabriquées à partir de matériaux tels que le cuir, le caoutchouc, les textiles, les matériaux synthétiques et la mousse. Les chaussures sont disponibles dans divers coloris et designs.',
            'pager' => $pagerfanta,
            'filtresParType' => $data['filtresParType'],
        ]);
    }

    #[Route('/sacs/{page<\d+>}', name: 'app_sacs')]
    public function sacs(Request $request, int $page = 1): Response
    {
        $formData = [];
        if ($request->isMethod('POST')) {
            $formData = $request->request->all();
        }

        $template = $request->isXmlHttpRequest() ? '_list.html.twig' : 'index.html.twig';

        $data = $this->getFiltres('Sacs');
        $pagerfanta = $this->getProduitsPager($data['categorie'], $page, $formData);

        return $this->render('categorie/'.$template, [
            'title' => 'Sacs',
            'description' => 'La collection de chaussures propose des bottes, ballerines, chaussures à talon, mocassins, chaussures oxford, sandales et claquettes. Les chaussures sont proposées par des marques de créateurs telles que Balenciaga, Prada, Hermès, Louis Vuitton, Timberland, Versace, Crocs, Birkenstock, Chanel, Dior, Gucci et Dr. Martens. La collection de chaussures comprend des chaussures de course, des chaussures de golf, des bottes de randonnée, des chaussures de football et des chaussures de basketball. Les chaussures sont fabriquées à partir de matériaux tels que le cuir, le caoutchouc, les textiles, les matériaux synthétiques et la mousse. Les chaussures sont disponibles dans divers coloris et designs.',
            'pager' => $pagerfanta,
            'filtresParType' => $data['filtresParType'],
        ]);
    }

    #[Route('/vetements/{page<\d+>}', name: 'app_vetements')]
    public function vetements(Request $request, int $page = 1): Response
    {
        $formData = [];
        if ($request->isMethod('POST')) {
            $formData = $request->request->all();
        }

        $template = $request->isXmlHttpRequest() ? '_list.html.twig' : 'index.html.twig';

        $data = $this->getFiltres('Vêtements');
        $pagerfanta = $this->getProduitsPager($data['categorie'], $page, $formData);

        return $this->render('categorie/'.$template, [
            'title' => 'Vêtements',
            'description' => 'La collection de chaussures propose des bottes, ballerines, chaussures à talon, mocassins, chaussures oxford, sandales et claquettes. Les chaussures sont proposées par des marques de créateurs telles que Balenciaga, Prada, Hermès, Louis Vuitton, Timberland, Versace, Crocs, Birkenstock, Chanel, Dior, Gucci et Dr. Martens. La collection de chaussures comprend des chaussures de course, des chaussures de golf, des bottes de randonnée, des chaussures de football et des chaussures de basketball. Les chaussures sont fabriquées à partir de matériaux tels que le cuir, le caoutchouc, les textiles, les matériaux synthétiques et la mousse. Les chaussures sont disponibles dans divers coloris et designs.',
            'pager' => $pagerfanta,
            'filtresParType' => $data['filtresParType'],
        ]);
    }

    private function getFiltres(string $categorieName): array
    {
        $categorie = $this->categorieRepository->getOne("name=$categorieName")->getId();
        $marques = $this->marqueRepository->findBy(['deletedAt' => null, 'isEnabled' => true]);
        $tailles = $this->tailleRepository->findBy(['categorie' => $categorie,'deletedAt' => null, 'isEnabled' => true]);
        $couleurs = $this->couleurRepository->findBy(['deletedAt' => null, 'isEnabled' => true],['name' => 'ASC']);
        
        $filtres = [
            'Marques' => $marques,
            'Tailles' => $tailles,
            'Couleurs'=> $couleurs
        ];

        foreach ($filtres as $key => $filtre) {
            foreach ($filtre as $row){
                $filtresParType[$key][] = $row;
            }
        }
       
        return [
            'filtresParType' => $filtresParType,
            'categorie' => $categorie
        ];
    }

    private function getProduitsPager(int $idCategorie, int $page, array $filtres = null): Pagerfanta
    {
        $params = "categorie=$idCategorie&deleted=false&enabled=true";

        $queryBuilder = $this->produitRepository->getAllQueryBuilder($params, $filtres);
        $pagerfanta = new Pagerfanta(new QueryAdapter($queryBuilder));
        $pagerfanta->setMaxPerPage(12);
        $pagerfanta->setCurrentPage($page);

        return $pagerfanta;
    }

}
