<?php

namespace App\Controller;

use App\Entity\Favoris;
use App\Entity\User;
use App\Form\UserFormType;
use App\Form\Model\UserFormModel;
use App\Repository\FavorisRepository;
use App\Repository\ProduitRepository;
use App\Repository\UserRepository;
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
        private UserRepository $userRepository
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
}
