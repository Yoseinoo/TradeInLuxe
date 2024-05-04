<?php

namespace App\Controller;

use App\Entity\Favoris;
use App\Repository\FavorisRepository;
use App\Repository\ProduitRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/profil')]
class ProfilController extends AbstractController
{
    public function __construct(
        private FavorisRepository $favorisRepository,
        private ProduitRepository $produitRepository
    ) {
    }

    #[Route('/', name: 'app_profil')]
    public function index(): Response
    {
        $user = $this->getUser();
        return $this->render('profil/index.html.twig', [
            'user' => $user,
            'current' => 'profil'
        ]);
    }

    #[Route('/favoris', name: 'app_favoris_profil')]
    public function favoris(Request $request): Response
    {
        $user = $this->getUser();
        
        if ($request->isMethod('POST')) {
            $params = $request->request->all();
                $favori = $this->favorisRepository->findOneBy(['produit' => $params['value'], 'user' => $user]);
                $this->favorisRepository->remove($favori,true);
        }

        $template = $request->isXmlHttpRequest() ? '_listFavoris.html.twig' : 'favoris.html.twig';

        $favoris = $this->favorisRepository->findBy(['user' => $user]);

        return $this->render('profil/'.$template, [
            'current' => 'favoris',
            'favoris' =>  $favoris
        ]);
    }

    #[Route('/update-favoris', name: 'app_favoris', methods: ['POST'])]
    public function setFavoris(Request $request): JsonResponse
    {
        $request = $request->request->all();
        $user= $this->getUser();
        if($request['checked'] == 'false'){
            $favori = $this->favorisRepository->findOneBy(['produit' => $request['value'], 'user' => $user]);
            $this->favorisRepository->remove($favori,true);
            return new JsonResponse(['success' => true]);
        }else{
            $produit = $this->produitRepository->findOneBy(['id' => $request['value']]);
            $favori = new Favoris;
            $favori->setUser($user);
            $favori->setProduit($produit);
            $this->favorisRepository->save($favori,true);
            return new JsonResponse(['success' => true]);
        }
    }

    #[Route('/update', name: 'app_update_profil')]
    public function update(): Response
    {
        $user = $this->getUser();
        return $this->render('profil/updateProfil.html.twig', [
            'user' => $user,
        ]);
    }
}
