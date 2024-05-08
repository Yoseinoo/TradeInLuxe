<?php

namespace App\Controller;

use App\Repository\ArticleRepository;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/admin')]
class AdminController extends AbstractController
{
    public function __construct(
        private ArticleRepository $articleRepository,
        private UserRepository $userRepository
    ) {
    }
    
    #[Route('/demandes', name: 'app_admin_demandes')]
    public function index(): Response
    {
        $articles = $this->articleRepository->findBy(['isEnabled'=>true,'isValidated'=>false,'deletedAt'=>null,'points'=>null]);
        
        return $this->render('profil/admin/demandes.html.twig', [
            'title' => 'Demandes en attente de validation',
            'current' => 'demandes',
            'articles' => $articles,
            'nombreDemandes' => count($articles)
        ]);
    }

    #[Route('/preview/{idArticle}', name: 'app_admin_traitement')]
    public function preview(Request $request): Response
    {
        $idArticle = $request->attributes->get('idArticle');
        $article = $this->articleRepository->findOneBy(['id'=>$idArticle,'isEnabled'=>true,'isValidated'=>false,'deletedAt'=>null,'points'=>null]);

        $nombreDemandes = count($this->articleRepository->findBy(['isEnabled'=>true,'isValidated'=>false,'deletedAt'=>null,'points'=>null]));


        return $this->render('profil/admin/traitement.html.twig', [
            'title' => 'Traitement article',
            'current'=> 'demandes',
            'article' => $article,
            'nombreDemandes' => $nombreDemandes
        ]);
    }

    #[Route('/update', name: 'app_admin_update', methods:['POST'])]
    public function update(Request $request): Response
    {
        $params = $request->request->all();

        switch (true) {
            case isset($params['points']):
                $this->accepterArticle($params);
                break;
            case isset($params['deleteOffreId']):
                $this->refuserArticle($params);
                break;
            default:
                break;
        }

        return $this->redirectToRoute('app_admin_demandes');
    }

    public function accepterArticle($params) 
    {
        $article = $this->articleRepository->findOneBy(['id'=>$params['acceptOffreId'],'isEnabled'=>true,'isValidated'=>false,'deletedAt'=>null,'points'=>null]);
        $article->setPoints($params['points']);
        $article->setIsValidated(true);

        try {
            $this->articleRepository->save($article,true);

            $this->addFlash(
                'success',
                'Succès !|L\'article a bien été validé.|success'
            );
            $this->redirectToRoute('app_admin_demandes');
        } catch (\Exception $e) {
            $this->addFlash(
                'danger',
                'Oops...|Une erreur s\'est produite.|error'
            );
        }        
    }

    public function refuserArticle($params) 
    {
        $article = $this->articleRepository->findOneBy(['id'=>$params['deleteOffreId'],'isEnabled'=>true,'isValidated'=>false,'deletedAt'=>null,'points'=>null]);
        $article->setIsValidated(false);
        $article->setIsEnabled(false);
        $article->setDeletedAt(new \DateTimeImmutable());

        try {
            $this->articleRepository->save($article,true);

            $this->addFlash(
                'success',
                'Succès !|L\'article a bien été refusé.|success'
            );
            $this->redirectToRoute('app_admin_demandes');
        } catch (\Exception $e) {
            $this->addFlash(
                'danger',
                'Oops...|Une erreur s\'est produite.|error'
            );
        }        
    }
}
