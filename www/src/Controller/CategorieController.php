<?php

namespace App\Controller;

use App\Repository\CategorieRepository;
use App\Repository\ProduitRepository;
use Pagerfanta\Doctrine\ORM\QueryAdapter;
use Pagerfanta\Pagerfanta;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CategorieController extends AbstractController
{
    public function __construct(
        private ProduitRepository $produitRepository,
        private CategorieRepository $categorieRepository
    ) {
    }

    #[Route('/chaussures/{page<\d+>}', name: 'app_chaussures')]
    public function chaussures(int $page = 1): Response
    {
        $categorie = $this->categorieRepository->getOne("name=Chaussures")->getId();
        $params = "categorie=$categorie&deleted=false&enabled=true";

        $queryBuilder = $this->produitRepository->getAllQueryBuilder($params);
        $pagerfanta = new Pagerfanta(new QueryAdapter($queryBuilder));
        $pagerfanta->setMaxPerPage(12);
        $pagerfanta->setCurrentPage($page);

        return $this->render('categorie/index.html.twig', [
            'title' => 'Chaussures',
            'description' => 'La collection de chaussures propose des bottes, ballerines, chaussures à talon, mocassins, chaussures oxford, sandales et claquettes. Les chaussures sont proposées par des marques de créateurs telles que Balenciaga, Prada, Hermès, Louis Vuitton, Timberland, Versace, Crocs, Birkenstock, Chanel, Dior, Gucci et Dr. Martens. La collection de chaussures comprend des chaussures de course, des chaussures de golf, des bottes de randonnée, des chaussures de football et des chaussures de basketball. Les chaussures sont fabriquées à partir de matériaux tels que le cuir, le caoutchouc, les textiles, les matériaux synthétiques et la mousse. Les chaussures sont disponibles dans divers coloris et designs.',
            'pager' => $pagerfanta,
        ]);
    }

    #[Route('/sacs/{page<\d+>}', name: 'app_sacs')]
    public function sacs(int $page = 1): Response
    {
        $categorie = $this->categorieRepository->getOne("name=Sacs")->getId();
        $params = "categorie=$categorie&deleted=false&enabled=true";

        $queryBuilder = $this->produitRepository->getAllQueryBuilder($params);
        $pagerfanta = new Pagerfanta(new QueryAdapter($queryBuilder));
        $pagerfanta->setMaxPerPage(12);
        $pagerfanta->setCurrentPage($page);

        return $this->render('categorie/index.html.twig', [
            'title' => 'Sacs',
            'description' => 'La collection de chaussures propose des bottes, ballerines, chaussures à talon, mocassins, chaussures oxford, sandales et claquettes. Les chaussures sont proposées par des marques de créateurs telles que Balenciaga, Prada, Hermès, Louis Vuitton, Timberland, Versace, Crocs, Birkenstock, Chanel, Dior, Gucci et Dr. Martens. La collection de chaussures comprend des chaussures de course, des chaussures de golf, des bottes de randonnée, des chaussures de football et des chaussures de basketball. Les chaussures sont fabriquées à partir de matériaux tels que le cuir, le caoutchouc, les textiles, les matériaux synthétiques et la mousse. Les chaussures sont disponibles dans divers coloris et designs.',
            'pager' => $pagerfanta,
        ]);
    }

    #[Route('/vetements/{page<\d+>}', name: 'app_vetements')]
    public function vetements(int $page = 1): Response
    {
        $categorie = $this->categorieRepository->getOne("name=Vêtements")->getId();
        $params = "categorie=$categorie&deleted=false&enabled=true";

        $queryBuilder = $this->produitRepository->getAllQueryBuilder($params);
        $pagerfanta = new Pagerfanta(new QueryAdapter($queryBuilder));
        $pagerfanta->setMaxPerPage(12);
        $pagerfanta->setCurrentPage($page);

        return $this->render('categorie/index.html.twig', [
            'title' => 'Vêtements',
            'description' => 'La collection de chaussures propose des bottes, ballerines, chaussures à talon, mocassins, chaussures oxford, sandales et claquettes. Les chaussures sont proposées par des marques de créateurs telles que Balenciaga, Prada, Hermès, Louis Vuitton, Timberland, Versace, Crocs, Birkenstock, Chanel, Dior, Gucci et Dr. Martens. La collection de chaussures comprend des chaussures de course, des chaussures de golf, des bottes de randonnée, des chaussures de football et des chaussures de basketball. Les chaussures sont fabriquées à partir de matériaux tels que le cuir, le caoutchouc, les textiles, les matériaux synthétiques et la mousse. Les chaussures sont disponibles dans divers coloris et designs.',
            'pager' => $pagerfanta,
        ]);
    }
}
