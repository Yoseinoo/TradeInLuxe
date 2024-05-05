<?php

namespace App\Controller;

use App\Entity\Article;
use App\Form\ArticleFormType;
use App\Form\Model\ArticleFormModel;
use App\Repository\ArticleRepository;
use App\Repository\ProduitRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class EchangeController extends AbstractController
{
    public function __construct(
        private ProduitRepository $produitRepository,
        private ArticleRepository $articleRepository,
    ) {
    }
    #[Route('/echange/{idProduit}', name: 'app_article_echange')]
    public function echange(Request $request): Response
    {
        $id = $request->attributes->get('idProduit');
        $produit = $this->produitRepository->findOneBy(['id' => $id]);
        $formModel = new ArticleFormModel();
        $form = $this->createForm(ArticleFormType::class, $formModel,['categorie' => $produit->getCategorie()->getId()]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $formData = $form->getData();
      
            $article = new Article();
            $article->setCategorie($produit->getCategorie());
            $article->setProduit($produit);
            $article->setUser($this->getUser());
            $article->setName($produit->getName());
            $article->setDescription($formData->description);
            $article->setEtat($formData->etat->getName());
            $article->setPathImage($produit->getPathImage());
            $caracterisqtiques = [
                'Marque' => $produit->getCaracteristiques()['Marque'],
                'Taille' =>$formData->taille,
                'Etat' => $formData->etat->getName()
            ];
            $article->setCaracteristiques($caracterisqtiques);

             
             foreach($formData->photos as $photo){
                 /** @var UploadedFile $file */
             $file = $photo->photo;
            
             $randomString = uniqid();
             $fileName =  $randomString.'_'.$file->getClientOriginalName();
             $file->move($this->getParameter('uploaded_file_directory').'/articles/',$fileName);
             $photos[] =  $fileName ;
             }

             $article->setPhotos($photos);

            
            
             try {
                $this->articleRepository->save($article,true);

                $this->addFlash(
                    'success',
                    'Succès !|Votre demande a bien été envoyé.|success'
                );
                $categorie =  $produit->getCategorie()->getName();
                if($categorie == 'Chaussures'){
                    $redirect = 'app_chaussures';
                }elseif($categorie == 'Sacs'){
                    $redirect = 'app_sacs';
                }else{
                    $redirect = 'app_vetements';
                }
                return $this->redirectToRoute($redirect);
            } catch (\Exception $e) {
                $this->addFlash(
                    'danger',
                    'Oops...|Une erreur s\'est produite.|error'
                );
            }

            
        }

        return $this->render('article/form.html.twig', [
            'title' => 'Echange',
            'form' => $form
        ]);
    }
}
