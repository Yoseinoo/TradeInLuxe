<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Article;
use App\Entity\Favoris;
use App\Form\UserFormType;
use App\Form\ArticleFormType;
use App\Form\Model\UserFormModel;
use App\Repository\UserRepository;
use App\Form\Model\ArticleFormModel;
use App\Repository\ArticlePropositionRepository;
use App\Repository\ArticleRepository;
use App\Repository\EtatRepository;
use App\Repository\FavorisRepository;
use App\Repository\ProduitRepository;
use App\Repository\PropositionRepository;
use App\Repository\TailleRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/profil')]
class ProfilController extends AbstractController
{
    public function __construct(
        private FavorisRepository $favorisRepository,
        private ProduitRepository $produitRepository,
        private UserRepository $userRepository,
        private ArticleRepository $articleRepository,
        private EtatRepository $etatRepository,
        private TailleRepository $tailleRepository,
        private PropositionRepository $propositionRepository,
        private ArticlePropositionRepository $articlePropositionRepository
    ) {
    }

    #[Route('/', name: 'app_profil')]
    public function index(): Response
    {
        /** @var User $user */
        $user = $this->getUser();
        $notifications = $user->getNotifications();
        $nombreDemandes = count($this->articleRepository->findBy(['isEnabled'=>true,'isValidated'=>false,'deletedAt'=>null,'points'=>null]));
        return $this->render('profil/index.html.twig', [
            'user' => $user,
            'current' => 'profil',
            'notifications' => $notifications,
            'nombreDemandes' => $nombreDemandes
        ]);
    }

    #[Route('/favoris', name: 'app_favoris_profil')]
    public function favoris(Request $request): Response
    {
        /** @var User $user */
        $user = $this->getUser();
        
        $notifications = $user->getNotifications();
        $nombreDemandes = count($this->articleRepository->findBy(['isEnabled'=>true,'isValidated'=>false,'deletedAt'=>null,'points'=>null]));

        if ($request->isMethod('POST')) {
            $params = $request->request->all();
                $favori = $this->favorisRepository->findOneBy(['produit' => $params['value'], 'user' => $user]);
                $this->favorisRepository->remove($favori,true);
        }

        $template = $request->isXmlHttpRequest() ? '_listFavoris.html.twig' : 'favoris.html.twig';

        $favoris = $this->favorisRepository->findBy(['user' => $user]);

        return $this->render('profil/'.$template, [
            'current' => 'favoris',
            'favoris' =>  $favoris,
            'notifications' => $notifications,
            'nombreDemandes' => $nombreDemandes
        ]);
    }

    #[Route('/mes-articles', name: 'app_articles_profil')]
    public function myArticles(Request $request): Response
    {
        /** @var User $user */
        $user = $this->getUser();

        $notifications = $user->getNotifications();
        $nombreDemandes = count($this->articleRepository->findBy(['isEnabled'=>true,'isValidated'=>false,'deletedAt'=>null,'points'=>null]));
        
        if ($request->isMethod('POST')) {
            $params = $request->request->all();
            if ($params['action'] == 'delete') {
                $article = $this->articleRepository->findOneBy(['id' => $params['article'], 'user' => $user]);

                $photos = $article->getPhotos();
                foreach ($photos as $photo) {
                    $oldFilePath = $this->getParameter('uploaded_file_directory') . '/articles/' . $photo;
                    if (file_exists($oldFilePath)) {
                        unlink($oldFilePath);
                    }
                }
                $this->articleRepository->remove($article, true);
            }else{
                return $this->redirectToRoute('app_update_article_profil', ['idArticle' => $params['article']]);
            }
            
        }

        $template = $request->isXmlHttpRequest() ? '_listArticles.html.twig' : 'articles.html.twig';

        $articles = $this->articleRepository->findBy(['user' => $user,'deletedAt' => null]);

        return $this->render('profil/'.$template, [
            'current' => 'articles',
            'articles' => $articles,
            'notifications' => $notifications,
            'nombreDemandes' => $nombreDemandes
        ]);
    }

    #[Route('/update-article/{idArticle}', name: 'app_update_article_profil')]
    public function updateArticle(Request $request): Response
    {

        $id = $request->attributes->get('idArticle');
        $oldArticle = $this->articleRepository->findOneBy(['id' => $id]);
        $formModel = new ArticleFormModel();
        $formModel->setDescription($oldArticle->getDescription());
        $etat = $this->etatRepository->findOneBy(['name' =>$oldArticle->getEtat()]);
        $formModel->setEtat($etat);
        $taille = $this->tailleRepository->findOneBy(['name' =>$oldArticle->getCaracteristiques()['Taille'], 'categorie' => $oldArticle->getCategorie()]);
        $formModel->setTaille($taille);
        $genre = $oldArticle->getCaracteristiques();
        $formModel->setGenre($genre['Genre']);
        $form = $this->createForm(ArticleFormType::class, $formModel,['action' => $this->generateUrl('app_update_article_profil',[
            'idArticle' => $id,
        ]),'categorie' => $oldArticle->getCategorie()->getId()]);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
      
            $formData = $form->getData();
      
            $oldArticle->setDescription($formData->description);
            $oldArticle->setEtat($formData->etat->getName());
            $caracterisqtiques = [
                'Marque' => $oldArticle->getCaracteristiques()['Marque'],
                'Taille' =>$formData->taille,
                'Etat' => $formData->etat->getName(),
                'Genre' => $formData->genre
            ];
            $oldArticle->setCaracteristiques($caracterisqtiques);

            $oldPhotos = $oldArticle->getPhotos();
            foreach ($oldPhotos as $photo) {
                $oldFilePath = $this->getParameter('uploaded_file_directory') . '/articles/' . $photo;
                if (file_exists($oldFilePath)) {
                    unlink($oldFilePath);
                }
            }
             foreach($formData->photos as $photo){
                 /** @var UploadedFile $file */
             $file = $photo->photo;
            
             $randomString = uniqid();
             $fileName =  $randomString.'_'.$file->getClientOriginalName();
             $file->move($this->getParameter('uploaded_file_directory').'/articles/',$fileName);
             $photos[] =  $fileName ;
             }

             $oldArticle->setPhotos($photos);

            
             try {
                $this->articleRepository->save($oldArticle,true);

                $this->addFlash(
                    'success',
                    'Succès !|Votre demande a bien été envoyé.|success'
                );
               
                return $this->redirectToRoute('app_articles_profil');
            } catch (\Exception $e) {
                $this->addFlash(
                    'danger',
                    'Oops...|Une erreur s\'est produite.|error'
                );
                return $this->redirectToRoute('app_articles_profil');
            }
        }
        if ($form->isSubmitted() && !$form->isValid()) {
           
            return $this->render('profil/articles.html.twig', [
                'error' => true,
                'form' => $form,
            ]);
        }

        $template = $request->isXmlHttpRequest() ? 'formUpdateArticle.html.twig' : 'articles.html.twig';
        return $this->render('profil/'.$template, [
           'form' => $form,
           'oldArticle' => $oldArticle
        ]);
    }

    #[Route('/preview-article', name: 'app_preview_article_profil',  methods: ['POST'])]
    public function preview(Request $request)
    {
            $params = $request->request->all();
            $oldArticle = $this->articleRepository->findOneBy(['id' => $params['article']]);
        
        return $this->render('profil/_targetPreview.html.twig', [
            'oldArticle' => $oldArticle
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

    #[Route('/update', name: 'app_update_profil', methods: ['POST'])]
    public function update(Request $request): Response
    {
        /** @var User $user */
        $user = $this->getUser();


        $formModel = new UserFormModel();
        $formModel->setFirstname($user->getFirstname());
        $formModel->setLastname($user->getLastname());
        $formModel->setEmail($user->getEmail());
        $formModel->setStreet($user->getStreet() ?? '');
        $formModel->setPostcode($user->getPostcode()?? '');
        $formModel->setCity($user->getCity()??'');        
        $form = $this->createForm(UserFormType::class, $formModel,['action' => $this->generateUrl('app_update_profil')]);
        $form->handleRequest($request);

        

        if ($form->isSubmitted() && $form->isValid()) {

            $formData = $form->getData();
       
            if($user->getPathImage() !== null && $formData->pathImage !== null){
                $oldFilePath = $this->getParameter('uploaded_file_directory').'/user/'.$user->getPathImage();
                if (file_exists($oldFilePath)) {
                    // Supprimer l'ancien fichier
                    unlink($oldFilePath);
                }
                /** @var UploadedFile $file */
                $file = $formData->pathImage;
                $fileName =  $user->getId().'_'.$file->getClientOriginalName();
                $file->move($this->getParameter('uploaded_file_directory').'/user/',$fileName);
                $user->setPathImage($fileName);

                if($user->getIsCompleted() == false){
                    $user->setIsCompleted(true);
                    $user->addPoints(200);
                }
            }elseif($user->getPathImage() == null && $formData->pathImage !== null){
                /** @var UploadedFile $file */
                $file = $formData->pathImage;
                $fileName =  $user->getId().'_'.$file->getClientOriginalName();
                $file->move($this->getParameter('uploaded_file_directory').'/user/',$fileName);
                $user->setPathImage($fileName);

                if($user->getIsCompleted() == false){
                    $user->setIsCompleted(true);
                    $user->addPoints(200);
                }
            }

            $user->setFirstname($formData->firstname);
            $user->setLastname($formData->lastname);
            $user->setEmail($formData->email);
            $user->setStreet($formData->street);
            $user->setPostcode($formData->postcode);
            $user->setCity($formData->city);

            

            try {
                $this->userRepository->save($user, true);

                $this->addFlash(
                    'success',
                    'Succès !|Votre profil a bien été modifié.|success'
                );
                return $this->redirectToRoute('app_profil');
            } catch (\Exception $e) {
                $this->addFlash(
                    'danger',
                    'Oops...|Une erreur s\'est produite.|error'
                );
            }

            return $this->redirectToRoute('app_profil');
        }

        if ($form->isSubmitted() && !$form->isValid()) {
           
            return $this->render('profil/index.html.twig', [
                'error' => true,
                'form' => $form,
            ]);
        }

        return $this->render('profil/_formUser.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/mes-echanges', name: 'app_echanges_profil')]
    public function echanges(): Response
    {
        /** @var User $user */
        $user = $this->getUser();
        $offres = $this->propositionRepository->findBy(['proprietaire' => $user, 'deletedAt' => null]);
        $mesPropositions = $this->propositionRepository->findBy(['demandeur' => $user, 'deletedAt' => null]);

       $user->setNotifications(0);
       $this->userRepository->save($user,true);

       $nombreDemandes = count($this->articleRepository->findBy(['isEnabled'=>true,'isValidated'=>false,'deletedAt'=>null,'points'=>null]));

        return $this->render('profil/echanges.html.twig', [
            'current' => 'echanges',
            'offres' => $offres,
            'mesPropositions' => $mesPropositions,
            'nombreDemandes' => $nombreDemandes
        ]);
    }

    #[Route('/mes-echanges/preview/{idProposition}', name: 'app_echanges_profil_preview')]
    public function echangesPreview(Request $request): Response
    {
        /** @var User $user */
        $user = $this->getUser();
        $idProposition = $request->attributes->get('idProposition');
        $proposition = $this->propositionRepository->findOneBy(['id'=>$idProposition,'deletedAt'=>null]); 
        $state = $user ==  $proposition->getProprietaire();
        return $this->render('profil/_previewOffre.html.twig', [
            'current' => 'echanges',
            'articleProposition' => $proposition->getArticleProposition(),
            'proposition' => $proposition,
            'state' => $state
        ]);
    }

    #[Route('/mes-echanges/update', name: 'app_echanges_update_profil', methods:['POST'])]
    public function updateEchanges(Request $request): Response
    {
         /** @var User $user */
        $user = $this->getUser();

        $params = $request->request->all();

        switch (true) {
            case isset($params['propositionId']):
                $this->annulerDemande($params,$user);
                break;
            case isset($params['deleteOffreId']):
                $this->refuserOffreRecu($params,$user);
                break;
            case isset($params['acceptOffreId']):
                $this->accepterOffreRecu($params,$user);
                break;
            case isset($params['numeroTransporteur']):
                $this->submitNumeroTransporteurProprietaire($params,$user);
                break;
            case isset($params['numeroTransporteurDemandeur']):
                $this->submitNumeroTransporteurDemandeur($params,$user);
                break;
            default:
                break;
        }

        return $this->redirectToRoute('app_echanges_profil');
    }

    public function annulerDemande($params, $user)
    {
        $maProposition = $this->propositionRepository->findOneBy(['id' => $params['propositionId'], 'demandeur' => $user, 'deletedAt' => null]);
        $points = $maProposition->getPoints();
        if ($points !== null) {
            $user->addPoints($points);
            $this->userRepository->save($user, true);

            $maProposition->setDeletedAt(new \DateTimeImmutable());
            $maProposition->setEtatProposition(false);
            $maProposition->setIsEnabled(false);

            try {
                $this->propositionRepository->save($maProposition, true);

                $this->addFlash(
                    'success',
                    'Succès !|Votre demande a bien été modifié.|success'
                );
                $this->redirectToRoute('app_echanges_profil');
            } catch (\Exception $e) {
                $this->addFlash(
                    'danger',
                    'Oops...|Une erreur s\'est produite.|error'
                );
            }
        } else {
            $articleProposition = $maProposition->getArticleProposition();
            $articleProposition->setDeletedAt(new \DateTimeImmutable());
            $articleProposition->setIsEnabled(false);

            $maProposition->setDeletedAt(new \DateTimeImmutable());
            $maProposition->setEtatProposition(false);
            $maProposition->setIsEnabled(false);

            try {
                $this->propositionRepository->save($maProposition, true);
                $this->articlePropositionRepository->save($articleProposition, true);

                $this->addFlash(
                    'success',
                    'Succès !|Votre demande a bien été modifié.|success'
                );
                $this->redirectToRoute('app_echanges_profil');
            } catch (\Exception $e) {
                $this->addFlash(
                    'danger',
                    'Oops...|Une erreur s\'est produite.|error'
                );
            }
        }
    }

    public function refuserOffreRecu($params, $user)
    {
        $offre = $this->propositionRepository->findOneBy(['id' => $params['deleteOffreId'], 'proprietaire' => $user, 'deletedAt' => null]);
        $points = $offre->getPoints();
        $demandeur = $this->userRepository->findOneBy(['id' => $offre->getDemandeur()]);
        if ($points !== null) {
            
            $demandeur->addPoints($points);
            $demandeur->addNotifications(1);
            $this->userRepository->save($demandeur, true);

            $offre->setDeletedAt(new \DateTimeImmutable());
            $offre->setEtatProposition(false);
            $offre->setIsEnabled(false);

            try {
                $this->propositionRepository->save($offre, true);

                $this->addFlash(
                    'success',
                    'Succès !|Votre demande a bien été traitée.|success'
                );
                $this->redirectToRoute('app_echanges_profil');
            } catch (\Exception $e) {
                $this->addFlash(
                    'danger',
                    'Oops...|Une erreur s\'est produite.|error'
                );
            }
        } else {
            $articleProposition = $offre->getArticleProposition();
            $articleProposition->setDeletedAt(new \DateTimeImmutable());
            $articleProposition->setIsEnabled(false);

            $offre->setDeletedAt(new \DateTimeImmutable());
            $offre->setEtatProposition(false);
            $offre->setIsEnabled(false);

            $demandeur->addNotifications(1);
            $this->userRepository->save($demandeur, true);

            try {
                $this->propositionRepository->save($offre, true);
                $this->articlePropositionRepository->save($articleProposition, true);

                $this->addFlash(
                    'success',
                    'Succès !|Votre demande a bien été traitée.|success'
                );
                $this->redirectToRoute('app_echanges_profil');
            } catch (\Exception $e) {
                $this->addFlash(
                    'danger',
                    'Oops...|Une erreur s\'est produite.|error'
                );
            }
        }
    }

    public function accepterOffreRecu($params, $user)
    {
        $offre = $this->propositionRepository->findOneBy(['id' => $params['acceptOffreId'], 'proprietaire' => $user, 'deletedAt' => null]);
        $points = $offre->getPoints();


        $article = $this->articleRepository->findOneBy(['id' => $offre->getArticle(), 'user' => $user]);
        $article->setDeletedAt(new \DateTimeImmutable());
        $article->setIsEnabled(false);
        $this->articleRepository->save($article, true);
        $demandeur = $this->userRepository->findOneBy(['id' => $offre->getDemandeur()]);
        if ($points !== null) {
            $offre->setEtatProposition(true);

           
            $demandeur->addPoints(25);
            $demandeur->setNotifications(1);
            $this->userRepository->save($demandeur);
            try {
                $this->propositionRepository->save($offre, true);

                $this->addFlash(
                    'success',
                    'Succès !|L\'offre a bien été acceptée. Merci de remplir le numéro du transporteur. Vous serez crédité des points une fois le produit entre nos mains.|success'
                );
            } catch (\Exception $e) {
                $this->addFlash(
                    'danger',
                    'Oops...|Une erreur s\'est produite.|error'
                );
            }
            $autresOffres = $this->propositionRepository->findBy(['article' => $offre->getArticle(), 'proprietaire' => $user, 'deletedAt' => null, 'etatProposition' => null, 'isEnabled' => true]);

            foreach ($autresOffres as $row) {
                $row->setEtatProposition(false);
                $row->setIsEnabled(false);
                $row->setDeletedAt(new \DateTimeImmutable());
                $this->propositionRepository->save($row, true);
            }


            $this->redirectToRoute('app_echanges_profil');
        } else {
            $offre->setEtatProposition(true);
            $demandeur->setNotifications(1);
            $this->userRepository->save($demandeur);
            try {
                $this->propositionRepository->save($offre, true);

                $this->addFlash(
                    'success',
                    'Succès !|L\'offre a bien été acceptée. Merci de remplir le numéro du transporteur. Vous serez crédité des points une fois le produit entre nos mains.|success'
                );
            } catch (\Exception $e) {
                $this->addFlash(
                    'danger',
                    'Oops...|Une erreur s\'est produite.|error'
                );
            }
            $autresOffres = $this->propositionRepository->findBy(['article' => $offre->getArticle(), 'proprietaire' => $user, 'deletedAt' => null, 'etatProposition' => null, 'isEnabled' => true]);

            foreach ($autresOffres as $row) {
                $row->setEtatProposition(false);
                $row->setIsEnabled(false);
                $row->setDeletedAt(new \DateTimeImmutable());
                $this->propositionRepository->save($row, true);
            }

            $articleProposition = $offre->getArticleProposition();
            $articleProposition->setIsEnabled(false);
            $this->articlePropositionRepository->save($articleProposition, true);


            $this->redirectToRoute('app_echanges_profil');
        }
    }

    public function submitNumeroTransporteurProprietaire($params, $user)
    {
        $offre = $this->propositionRepository->findOneBy(['id' => $params['offreIdTransporteur'], 'proprietaire' => $user, 'deletedAt' => null]);
        $offre->setIsEnabled(false);
        try {
            $this->propositionRepository->save($offre, true);

            $this->addFlash(
                'success',
                'Succès !|Le transporteur a bien été enregistré.|success'
            );
        } catch (\Exception $e) {
            $this->addFlash(
                'danger',
                'Oops...|Une erreur s\'est produite.|error'
            );
        }
    }

    public function submitNumeroTransporteurDemandeur($params, $user)
    {
        $offre = $this->propositionRepository->findOneBy(['id' => $params['offreIdTransporteur'], 'demandeur' => $user, 'deletedAt' => null]);
        $offre->setTransported(true);
        try {
            $this->propositionRepository->save($offre, true);

            $this->addFlash(
                'success',
                'Succès !|Le transporteur a bien été enregistré.|success'
            );
        } catch (\Exception $e) {
            $this->addFlash(
                'danger',
                'Oops...|Une erreur s\'est produite.|error'
            );
        }
    }
}
