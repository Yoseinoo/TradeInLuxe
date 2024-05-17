<?php

namespace App\Controller;

use App\Entity\Marque;
use App\Entity\Taille;
use App\Entity\Couleur;
use App\Entity\Produit;
use Pagerfanta\Pagerfanta;
use App\Form\ProduitFormType;
use App\Repository\UserRepository;
use App\Form\Model\ProduitFormModel;
use App\Repository\MarqueRepository;
use App\Repository\TailleRepository;
use App\Repository\ArticleRepository;
use App\Repository\CouleurRepository;
use App\Repository\ProduitRepository;
use Pagerfanta\Doctrine\ORM\QueryAdapter;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/admin')]
class AdminController extends AbstractController
{
    public function __construct(
        private ArticleRepository $articleRepository,
        private ProduitRepository $produitRepository,
        private UserRepository $userRepository,
        private MarqueRepository $marqueRepository,
        private TailleRepository $tailleRepository,
        private CouleurRepository $couleurRepository,
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

    #[Route('/ajout', name: 'app_admin_ajout')]
    public function ajout(Request $request): Response
    {
        $formModel = new ProduitFormModel();
        $form = $this->createForm(ProduitFormType::class, $formModel,);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $formData = $form->getData();
    
            $produit = new Produit();
            $produit->setName($formData->name);
            $produit->setCategorie($formData->categorie);
            $produit->setDescription($formData->description);
            $caracterisqtiques = [
                'Marque' => $formData->marque,
                'Taille' => $formData->taille,
                'Couleur' => $formData->couleur,
                'Genre' => $formData->genre
            ];
            $produit->setCaracteristiques($caracterisqtiques);

            $marques = $this->marqueRepository->findBy(['isEnabled'=>true,'deletedAt'=>null]);
            $tailles= $this->tailleRepository->findBy(['categorie'=>$formData->categorie,'isEnabled'=>true,'deletedAt'=>null]);
            $couleurs= $this->couleurRepository->findBy(['isEnabled'=>true,'deletedAt'=>null]);

            // Création des tableaux pour stocker les noms des marques, tailles et couleurs
            $marquesExistantes = [];
            $taillesExistantes = [];
            $couleursExistantes = [];

            // Remplissage des tableaux avec les noms des marques, tailles et couleurs existantes en base de données
            foreach ($marques as $marque) {
                $marquesExistantes[] = $marque->getName();
            }

            foreach ($tailles as $taille) {
                $taillesExistantes[] = $taille->getName();
            }

            foreach ($couleurs as $couleur) {
                $couleursExistantes[] = $couleur->getName();
            }

            if (!in_array($formData->marque, $marquesExistantes)) {
               $marque = new Marque();
               $marque->setName($formData->marque);
               $marque->setIsEnabled(true);
               $this->marqueRepository->save($marque,true);

            } 
            if (!in_array($formData->taille, $taillesExistantes)) {
                $taille = new Taille();
                $taille->setName($formData->taille);
                $taille->setCategorie($formData->categorie);
                $taille->setIsEnabled(true);
                $this->tailleRepository->save($taille,true);
             } 
             if (!in_array($formData->couleur, $couleursExistantes)) {
                $couleur = new Couleur();
                $couleur->setName($formData->couleur);
                $couleur->setIsEnabled(true);
                $this->couleurRepository->save($couleur,true);
 
             } 
            
             foreach($formData->photos as $key => $photo){
                 /** @var UploadedFile $file */
                $file = $photo->photo;
                
                $randomString = uniqid();
                $fileName =  $randomString.'_'.$file->getClientOriginalName();
                if($key == 0){
                    $produit->setPathImage($fileName );
                    }
                $file->move($this->getParameter('uploaded_file_directory').'/produits/',$fileName);
                $photos[] =  $fileName ;
             }
             $produit->setPhotos($photos);

            
            
             try {
                $this->produitRepository->save($produit,true);

                $this->addFlash(
                    'success',
                    'Succès !|Le produit a bien été enregistré.|success'
                );
              
                return $this->redirectToRoute('app_admin_ajout');
            } catch (\Exception $e) {
                $this->addFlash(
                    'danger',
                    'Oops...|Une erreur s\'est produite.|error'
                );
            }
        }
        $nombreDemandes = count($this->articleRepository->findBy(['isEnabled'=>true,'isValidated'=>false,'deletedAt'=>null,'points'=>null]));
        return $this->render('profil/admin/ajout.html.twig', [
            'title' => 'Ajouter un nouveau produit',
            'current' => 'ajout',
            'currentChoice' => 'ajout',
            'form' => $form,
            'nombreDemandes' => $nombreDemandes
        ]);
    }

    #[Route('/gestion/{page<\d+>}', name: 'app_admin_gestion')]
    public function gestion(Request $request, int $page = 1): Response
    {
      
        
        if ($request->isMethod('POST')) {       
            $params = $request->request->all();
            if ($params['action'] == 'delete') {
                $produit = $this->produitRepository->findOneBy(['id' => $params['produit'], 'isEnabled' => true, 'deletedAt' => null]);
                $articles = $this->articleRepository->findBy(['produit'=> $produit, 'isEnabled' => true, 'deletedAt' => null]);

                foreach($articles as $row){
                    $row->setIsEnabled(false);
                    $row->setDeletedAt(new \DateTimeImmutable());
                    $this->articleRepository->save($row,true);
                }

                $produit->setIsEnabled(false);
                $produit->setDeletedAt(new \DateTimeImmutable());
                $photos = $produit->getPhotos();
                foreach ($photos as $photo) {
                    $oldFilePath = $this->getParameter('uploaded_file_directory') . '/produits/' . $photo;
                    if (file_exists($oldFilePath)) {
                        unlink($oldFilePath);
                    }
                }
                
                try {
                    $this->produitRepository->save($produit, true);
    
                    $this->addFlash(
                        'success',
                        'Succès !|Le produit a bien été supprimé.|success'
                    );
                    $pagerfanta = $this->getProduitsPager($page);
                    return $this->render('profil/admin/_listProduits.html.twig', [
                        'title' => 'Gestion des produits',
                        'current' => 'ajout',
                        'currentChoice' => 'gestion',
                        'pager' => $pagerfanta
                    ]);
                } catch (\Exception $e) {
                    $this->addFlash(
                        'danger',
                        'Oops...|Une erreur s\'est produite.|error'
                    );
                }
            }elseif($params['action'] == 'update'){
                $produit = $this->produitRepository->findOneBy(['id' => $params['produit'], 'isEnabled' => true, 'deletedAt' => null]);
                $formModel = new ProduitFormModel();
                $formModel->setName($produit->getName());
                $formModel->setCategorie($produit->getCategorie());
                $formModel->setDescription($produit->getDescription());
                $formModel->setMarque($produit->getCaracteristiques()['Marque']);
                $formModel->setTaille($produit->getCaracteristiques()['Taille']);
                $formModel->setGenre($produit->getCaracteristiques()['Genre']);
                $formModel->setCouleur($produit->getCaracteristiques()['Couleur']);
                $form = $this->createForm(ProduitFormType::class, $formModel,['action' => $this->generateUrl('app_admin_gestion_update',['idProduit' => $produit->getId()]), 'required' => false]);
                $form->handleRequest($request);


                return $this->render('profil/admin/_updateForm.html.twig', [
                    'current' => 'ajout',
                    'currentChoice' => 'gestion',
                    'form' =>$form
                ]);
            }
            
        }

        $pagerfanta = $this->getProduitsPager($page);
        $nombreDemandes = count($this->articleRepository->findBy(['isEnabled'=>true,'isValidated'=>false,'deletedAt'=>null,'points'=>null]));
        return $this->render('profil/admin/ajout.html.twig', [
            'title' => 'Gestion des produits',
            'current' => 'ajout',
            'currentChoice' => 'gestion',
            'pager' => $pagerfanta,
            'nombreDemandes' => $nombreDemandes
        ]);
    }

    #[Route('/gestion/update/{idProduit}', name: 'app_admin_gestion_update')]
    public function gestionUpdate(Request $request): Response
    {
                $idProduit = $request->attributes->get('idProduit');
                $produit = $this->produitRepository->findOneBy(['id' => $idProduit, 'isEnabled' => true, 'deletedAt' => null]);
                $formModel = new ProduitFormModel();
                $formModel->setName($produit->getName());
                $formModel->setCategorie($produit->getCategorie());
                $formModel->setDescription($produit->getDescription());
                $formModel->setMarque($produit->getCaracteristiques()['Marque']);
                $formModel->setTaille($produit->getCaracteristiques()['Taille']);
                $formModel->setGenre($produit->getCaracteristiques()['Genre']);
                $formModel->setCouleur($produit->getCaracteristiques()['Couleur']);
                $form = $this->createForm(ProduitFormType::class, $formModel,['action' => $this->generateUrl('app_admin_gestion_update',['idProduit' => $produit->getId()]), 'required' => false]);
                $form->handleRequest($request);
               
                if ($form->isSubmitted() && $form->isValid()) {
                    $formData = $form->getData();
    
                    
                    $produit->setName($formData->name);
                    $produit->setCategorie($formData->categorie);
                    $produit->setDescription($formData->description);
                    $caracterisqtiques = [
                        'Marque' => $formData->marque,
                        'Taille' => $formData->taille,
                        'Couleur' => $formData->couleur,
                        'Genre' => $formData->genre
                    ];
                    $produit->setCaracteristiques($caracterisqtiques);
        
                    $marques = $this->marqueRepository->findBy(['isEnabled'=>true,'deletedAt'=>null]);
                    $tailles= $this->tailleRepository->findBy(['categorie'=>$formData->categorie,'isEnabled'=>true,'deletedAt'=>null]);
                    $couleurs= $this->couleurRepository->findBy(['isEnabled'=>true,'deletedAt'=>null]);
        
                    // Création des tableaux pour stocker les noms des marques, tailles et couleurs
                    $marquesExistantes = [];
                    $taillesExistantes = [];
                    $couleursExistantes = [];
        
                    // Remplissage des tableaux avec les noms des marques, tailles et couleurs existantes en base de données
                    foreach ($marques as $marque) {
                        $marquesExistantes[] = $marque->getName();
                    }
        
                    foreach ($tailles as $taille) {
                        $taillesExistantes[] = $taille->getName();
                    }
        
                    foreach ($couleurs as $couleur) {
                        $couleursExistantes[] = $couleur->getName();
                    }
        
                    if (!in_array($formData->marque, $marquesExistantes)) {
                       $marque = new Marque();
                       $marque->setName($formData->marque);
                       $marque->setIsEnabled(true);
                       $this->marqueRepository->save($marque,true);
        
                    } 
                    if (!in_array($formData->taille, $taillesExistantes)) {
                        $taille = new Taille();
                        $taille->setName($formData->taille);
                        $taille->setCategorie($formData->categorie);
                        $taille->setIsEnabled(true);
                        $this->tailleRepository->save($taille,true);
                     } 
                     if (!in_array($formData->couleur, $couleursExistantes)) {
                        $couleur = new Couleur();
                        $couleur->setName($formData->couleur);
                        $couleur->setIsEnabled(true);
                        $this->couleurRepository->save($couleur,true);
         
                     } 
                    
                     if(!is_null($formData->photos[0])){
                        $oldPhotos = $produit->getPhotos();
                        $oldPathImage = $produit->getPathImage();
                        $oldFilePathImage = $this->getParameter('uploaded_file_directory') . '/produits/' . $oldPathImage;
                        if (file_exists($oldFilePathImage)) {
                            unlink($oldFilePathImage);
                        }
                        foreach ($oldPhotos as $photo) {
                            $oldFilePath = $this->getParameter('uploaded_file_directory') . '/produits/' . $photo;
                            if (file_exists($oldFilePath)) {
                                unlink($oldFilePath);
                            }
                        }

                        foreach($formData->photos as $key => $photo){
                         /** @var UploadedFile $file */
                        $file = $photo->photo;
                        
                        $randomString = uniqid();
                        $fileName =  $randomString.'_'.$file->getClientOriginalName();
                        if($key == 0){
                            $produit->setPathImage($fileName);
                            }
                        $file->move($this->getParameter('uploaded_file_directory').'/produits/',$fileName);
                        $photos[] =  $fileName ;
                     }
                        $produit->setPhotos($photos);
                     }
                     
        
                    
                    
                     try {
                        $this->produitRepository->save($produit,true);
        
                        $this->addFlash(
                            'success',
                            'Succès !|Le produit a bien été mis à jour.|success'
                        );
                      
                        return $this->redirectToRoute('app_admin_gestion');
                    } catch (\Exception $e) {
                        $this->addFlash(
                            'danger',
                            'Oops...|Une erreur s\'est produite.|error'
                        );
                    }
                }

        return $this->render('profil/admin/ajout.html.twig', [
            'title' => 'Mise à jour d\'un produit',
            'current' => 'ajout',
            'currentChoice' => 'gestion',
            'formUpdate' => true,
            'form' =>$form
        ]);
    }

    private function getProduitsPager(int $page): Pagerfanta
    {
        $params = "deleted=false&isEnabled=true";

        $queryBuilder = $this->produitRepository->getAllQueryBuilder($params);
        $pagerfanta = new Pagerfanta(new QueryAdapter($queryBuilder));
        $pagerfanta->setMaxPerPage(12);
        $pagerfanta->getNbPages() > 1 ? $pagerfanta->setCurrentPage($page) : '';

        return $pagerfanta;
    }
}
